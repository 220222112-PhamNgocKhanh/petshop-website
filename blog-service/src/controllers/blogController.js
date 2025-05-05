const jwt = require('jsonwebtoken');
const Blog = require('../models/Blog');
const parseRequestBody = require('../utils/parseRequestBody');

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

// Tạo bài blog (bỏ kiểm tra admin)
exports.createPost = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded || !exports.checkAdmin(decoded)) {
        console.log(decoded);
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Admin access required' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { title, content } = body;
        if (!title || !content) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Title and content are required' }));
        }

        try {
            const newPost = await Blog.create({ title, content });
            res.writeHead(201, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Post created successfully', post: newPost }));
        } catch (error) {
            console.error('Create post error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
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

// Cập nhật bài blog (bỏ kiểm tra admin)
exports.updatePost = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded || !exports.checkAdmin(decoded)) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Admin access required' }));
    }

    const id = req.url.split('/').pop();

    parseRequestBody(req, res, async (body) => {
        const { title, content } = body;
        try {
            const post = await Blog.findByPk(id);
            if (!post) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Post not found' }));
            }

            await post.update({
                title: title || post.title,
                content: content || post.content,
            });

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Post updated successfully', post }));
        } catch (error) {
            console.error('Update post error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

// Xóa bài blog (bỏ kiểm tra admin)
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

        await post.destroy();
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Post deleted successfully' }));
    } catch (error) {
        console.error('Delete post error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};