const jwt = require('jsonwebtoken');
const Blog = require('../models/blog');
const parseRequestBody = require('../utils/parseRequestBody');
const { processImage } = require('../utils/uploadHandler');
const path = require('path');
const fs = require('fs');
const multer = require('multer');

// Cấu hình multer để xử lý upload file
const storage = multer.diskStorage({
    destination: function(req, file, cb) {
        const uploadDir = path.join(__dirname, '../../public/images');
        if (!fs.existsSync(uploadDir)) {
            fs.mkdirSync(uploadDir, { recursive: true });
        }
        cb(null, uploadDir);
    },
    filename: function(req, file, cb) {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        const ext = path.extname(file.originalname);
        cb(null, 'blog-' + uniqueSuffix + ext);
    }
});

// Kiểm tra kiểu file
const fileFilter = (req, file, cb) => {
    if (file.mimetype.startsWith('image/')) {
        cb(null, true);
    } else {
        cb(new Error('Chỉ chấp nhận file hình ảnh!'), false);
    }
};

const upload = multer({ 
    storage: storage, 
    fileFilter: fileFilter,
    limits: { fileSize: 5 * 1024 * 1024 } // Giới hạn kích thước file là 5MB
});

// Xác thực token từ header Authorization
exports.verifyToken = (req) => {
    const authHeader = req.headers.authorization;
    if (!authHeader) return null;
    const token = authHeader.split(' ')[1];
    try {
        return jwt.verify(token, process.env.JWT_SECRET || 'petshop');
    } catch {
        return null;
    }
    // return true; // Bỏ qua xác thực token, luôn trả về true để test
};

// Kiểm tra vai trò admin
exports.checkAdmin = (decoded) => {
    return decoded && decoded.role === 'admin';
    // return true; // Bỏ qua kiểm tra role, luôn trả về true để test
};

// Tạo bài blog
exports.createPost = async (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded || !exports.checkAdmin(decoded)) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Admin access required' }));
    }

    const { title, content } = req.body;
    if (!title || !content) {
        res.writeHead(400, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Title and content are required' }));
    }

    try {
        let thumbnailPath = '/images/default-thumbnail.jpg';

        if (req.file) {
            // Lưu đường dẫn tương đối của ảnh
            thumbnailPath = '/images/' + req.file.filename;
        }

        const newPost = await Blog.create({
            title,
            content,
            thumbnail: thumbnailPath,
        });

        res.writeHead(201, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({
            message: 'Post created successfully',
            post: newPost
        }));
    } catch (error) {
        console.error('Create post error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};


// Lấy danh sách bài blog (công khai, không cần thay đổi)
exports.getPosts = async (req, res) => {
    try {
        const posts = await Blog.findAll();
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(posts));
    } catch (error) {
        console.error('Get posts error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};

// Lấy bài blog theo ID (công khai, không cần thay đổi)
exports.getPostById = async (req, res) => {
    const id = req.params.id;

    try {
        const post = await Blog.findByPk(id);
        if (!post) {
            res.writeHead(404, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Post not found' }));
        }

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(post));
    } catch (error) {
        console.error('Get post error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};

// Cập nhật bài blog
exports.updatePost = async (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded || !exports.checkAdmin(decoded)) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Admin access required' }));
    }

    const id = req.params.id; // Sử dụng req.params.id thay vì tách từ url

    try {
        const post = await Blog.findByPk(id);
        if (!post) {
            res.writeHead(404, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Post not found' }));
        }

        const { title, content } = req.body;

        let updateData = {
            title: title || post.title,
            content: content || post.content
        };

        // Xử lý upload hình ảnh mới nếu có
        if (req.file) {
            const thumbnailPath = '/images/' + req.file.filename;
            updateData.thumbnail = thumbnailPath;

            // Xóa hình ảnh cũ nếu không phải hình mặc định
            if (post.thumbnail && post.thumbnail !== '/images/default-thumbnail.jpg') {
                const oldImagePath = path.join(__dirname, '../../public', post.thumbnail);
                if (fs.existsSync(oldImagePath)) {
                    fs.unlinkSync(oldImagePath);
                }
            }
        }

        await post.update(updateData);

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ 
            message: 'Post updated successfully', 
            post 
        }));
    } catch (error) {
        console.error('Update post error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};

// Xóa bài blog
exports.deletePost = async (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded || !exports.checkAdmin(decoded)) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Admin access required' }));
    }

    const id = req.url.split('/').pop();

    try {
        const post = await Blog.findByPk(id);
        if (!post) {
            res.writeHead(404, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Post not found' }));
        }

        // Xóa hình ảnh thumbnail nếu không phải hình mặc định
        if (post.thumbnail && post.thumbnail !== '/images/default-thumbnail.jpg') {
            const imagePath = path.join(__dirname, '../../public', post.thumbnail);
            if (fs.existsSync(imagePath)) {
                fs.unlinkSync(imagePath);
            }
        }

        await post.destroy();
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Post deleted successfully' }));
    } catch (error) {
        console.error('Delete post error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};