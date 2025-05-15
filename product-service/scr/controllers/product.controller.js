const db = require('../db/db.js');
const { body, param, validationResult } = require('express-validator');
const fs = require('fs');
const path = require('path');
const multer = require('multer');

// Cấu hình multer để xử lý upload file
const storage = multer.diskStorage({
    destination: function(req, file, cb) {
        console.log('In storage destination, body:', req.body);
        // Chúng ta cần lấy category từ request, không phải từ req.body vì multer chưa xử lý xong
        // Thay vào đó, sử dụng một giá trị mặc định
        const defaultDir = path.join(__dirname, '../../../backend/image', 'default');
        
        // Tạo thư mục nếu chưa tồn tại
        if (!fs.existsSync(defaultDir)) {
            console.log(`Creating default directory: ${defaultDir}`);
            fs.mkdirSync(defaultDir, { recursive: true });
        }
        
        cb(null, defaultDir);
    },
    filename: function(req, file, cb) {
        // Đảm bảo tên file độc nhất bằng cách thêm timestamp
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        const ext = path.extname(file.originalname);
        cb(null, file.fieldname + '-' + uniqueSuffix + ext);
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
// Validate dữ liệu đầu vào khi tạo sản phẩm
const validateProduct = [
    body('name').notEmpty().withMessage('Name is required'),
    body('price').isFloat({ min: 0 }).withMessage('Price must be a positive number'),
    body('category').notEmpty().withMessage('Category is required'),
    (req, res, next) => {
        const errors = validationResult(req);
        if (!errors.isEmpty()) {
            return res.status(400).json({ errors: errors.array() });
        }
        next();
    },
];

// Tạo sản phẩm
const createProduct = async (req, res) => {
    const { name, price, description, amount, image, category } = req.body;
    try {
        const [result] = await db.execute(
            'INSERT INTO products (name, price, description, amount, image, category, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())',
            [name, price, description, amount, image, category]
        );
        res.status(201).json({ message: 'Product created', productId: result.insertId });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Cập nhật sản phẩm
const updateProduct = async (req, res) => {
    const { id } = req.params;
    const { name, price, description, amount, image, category } = req.body;

    let query = 'UPDATE products SET';
    const params = [];

    if (name) { query += ' name = ?,'; params.push(name); }
    if (price) { query += ' price = ?,'; params.push(price); }
    if (description !== undefined) { query += ' description = ?,'; params.push(description); }
    if (amount !== undefined) { query += ' amount = ?,'; params.push(amount); }
    if (image !== undefined) { query += ' image = ?,'; params.push(image); }
    if (category !== undefined) { query += ' category = ?,'; params.push(category); }

    query = query.slice(0, -1); // Xoá dấu phẩy cuối
    query += ' WHERE id = ?';
    params.push(id);

    try {
        const [result] = await db.execute(query, params);
        if (result.affectedRows === 0) {
            return res.status(404).json({ message: 'Product not found' });
        }
        res.status(200).json({ message: `Product ${id} updated` });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Lấy danh sách sản phẩm
const getProducts = async (req, res) => {
    const { limit = 10, offset = 0, search = '', min_price, max_price, category } = req.query;
    let query = 'SELECT * FROM products WHERE name LIKE ?';
    const params = [`%${search}%`];

    if (min_price) {
        query += ' AND price >= ?';
        params.push(min_price);
    }
    if (max_price) {
        query += ' AND price <= ?';
        params.push(max_price);
    }
    if (category) {
        query += ' AND category LIKE ?';
        params.push(`%${category}%`);
    }

    query += ` ORDER BY created_at DESC LIMIT ${parseInt(limit)} OFFSET ${parseInt(offset)}`;

    try {
        const [products] = await db.execute(query, params);
        res.status(200).json({ products });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Lấy sản phẩm theo ID
const getProductById = async (req, res) => {
    const { id } = req.params;
    try {
        const [product] = await db.execute('SELECT * FROM products WHERE id = ?', [id]);
        if (product.length === 0) {
            return res.status(404).json({ message: 'Product not found' });
        }
        res.status(200).json({ product: product[0] });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Tìm theo tên sản phẩm
const getProductByName = async (req, res) => {
    const { name } = req.params;
    try {
        const [products] = await db.execute(
            'SELECT * FROM products WHERE LOWER(name) LIKE ?',
            [`%${name.toLowerCase()}%`]
        );
        if (products.length === 0) {
            return res.status(404).json({ message: 'Không tìm thấy sản phẩm nào phù hợp' });
        }
        res.status(200).json({ products });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Tìm theo danh mục
const getProductBycategory = async (req, res) => {
    const { categoryName } = req.params;
    try {
        const [products] = await db.execute(
            'SELECT * FROM products WHERE LOWER(category) LIKE ?',
            [`%${categoryName.toLowerCase()}%`]
        );
        if (products.length === 0) {
            return res.status(404).json({ message: 'Không tìm thấy sản phẩm nào phù hợp' });
        }
        res.status(200).json({ products });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Xoá sản phẩm
const deleteProduct = async (req, res) => {
    const { id } = req.params;
    try {
        const [result] = await db.execute('DELETE FROM products WHERE id = ?', [id]);
        if (result.affectedRows === 0) {
            return res.status(404).json({ message: 'Product not found' });
        }
        res.status(200).json({ message: `Product ${id} deleted` });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};
const latestProduct = async (req, res) => {
    try {
        const [products] = await db.execute('SELECT * FROM products ORDER BY created_at DESC LIMIT 6');
        res.status(200).json({ products });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

const countByCategory = async (req, res) => {
    try {
        const [results] = await db.execute(`
            SELECT category, COUNT(*) as count
            FROM products
            GROUP BY category
        `);

        res.status(200).json({ counts: results });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Tìm kiếm sản phẩm theo cả danh mục và từ khóa
const searchInCategory = async (req, res) => {
    const { categoryName, keyword } = req.params;
    try {
        const [products] = await db.execute(
            'SELECT * FROM products WHERE LOWER(category) LIKE ? AND LOWER(name) LIKE ?',
            [`%${categoryName.toLowerCase()}%`, `%${keyword.toLowerCase()}%`]
        );
        if (products.length === 0) {
            return res.status(404).json({ message: 'Không tìm thấy sản phẩm nào phù hợp' });
        }
        res.status(200).json({ products });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Middleware để xử lý upload ảnh
const processUpload = (req, res, next) => {
    console.log('Starting upload process...');
    console.log('Raw body before upload:', req.body);
    
    // Tạo single upload instance
    const singleUpload = upload.single('image');
    
    // Xử lý upload trước, sau đó mới kiểm tra dữ liệu
    singleUpload(req, res, function(err) {
        if (err instanceof multer.MulterError) {
            // Lỗi từ Multer
            console.error('Multer error:', err);
            return res.status(400).json({ message: `Lỗi upload: ${err.message}` });
        } else if (err) {
            // Lỗi khác
            console.error('Upload error:', err);
            return res.status(500).json({ message: `Lỗi server: ${err.message}` });
        }
        
        console.log('After upload, req.body:', req.body);
        console.log('After upload, req.file:', req.file);
        
        // Sau khi upload thành công, di chuyển file nếu cần
        if (req.file && req.body.category) {
            try {
                // Di chuyển file đến thư mục chính xác theo category
                const tempPath = req.file.path;
                const targetDir = path.join(__dirname, '../../../backend/image', req.body.category);
                
                // Tạo thư mục nếu chưa tồn tại
                if (!fs.existsSync(targetDir)) {
                    console.log(`Creating category directory: ${targetDir}`);
                    fs.mkdirSync(targetDir, { recursive: true });
                }
                
                const targetPath = path.join(targetDir, req.file.filename);
                
                // Di chuyển file
                if (tempPath !== targetPath) {
                    fs.renameSync(tempPath, targetPath);
                    req.file.path = targetPath; // Cập nhật path trong req.file
                    console.log(`Moved file to: ${targetPath}`);
                }
            } catch (error) {
                console.error('Error moving file:', error);
                // Không throw error ở đây, chỉ log lỗi thôi
            }
        }
        
        // Không có lỗi, tiếp tục
        next();
    });
};

// Upload ảnh và tạo sản phẩm mới
const uploadProductImage = async (req, res) => {
    try {
        console.log('Processing product upload with image...');
        console.log('Request body after multer:', req.body);
        
        // Multer đã xử lý upload ảnh, nên file đã được lưu vào thư mục
        // và thông tin file đã được thêm vào req.file
        if (!req.file) {
            console.error('No file in request');
            return res.status(400).json({ message: 'Không có file nào được upload' });
        }

        // Lấy thông tin sản phẩm từ form, sử dụng giá trị mặc định nếu thiếu
        const name = req.body.name || 'Sản phẩm không tên';
        const price = req.body.price || 0;
        const description = req.body.description || '';
        const amount = req.body.amount || 0;
        const category = req.body.category || 'default';
        
        // Log các thông tin đã trích xuất
        console.log('Extracted product data:', { name, price, description, amount, category });
        
        // Đường dẫn tương đối của file (chỉ lưu tên file vào DB)
        const image = req.file.filename;
        
        console.log('Inserting product to database with image:', image);
        
        // Lưu thông tin sản phẩm vào database
        const [result] = await db.execute(
            'INSERT INTO products (name, price, description, amount, image, category, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())',
            [name, price, description, amount, image, category]
        );
        
        console.log('Product created successfully with ID:', result.insertId);
        
        res.status(201).json({ 
            message: 'Product created with image',
            productId: result.insertId,
            image: image
        });
    } catch (error) {
        console.error('Error in uploadProductImage:', error);
        res.status(500).json({ 
            error: error.message,
            stack: process.env.NODE_ENV === 'development' ? error.stack : undefined
        });
    }
};

// Upload ảnh và cập nhật sản phẩm
// Upload ảnh và cập nhật sản phẩm
const updateProductWithImage = async (req, res) => {
    try {
        const { id } = req.params;

        // Xác thực sản phẩm tồn tại
        const [existingProduct] = await db.execute('SELECT * FROM products WHERE id = ?', [id]);
        if (existingProduct.length === 0) {
            return res.status(404).json({ message: 'Product not found' });
        }

        const { name, price, description, amount, category } = req.body;
        let image = existingProduct[0].image;

        // Nếu có file ảnh mới được upload
        if (req.file) {
            image = req.file.filename;

            // Xoá file cũ nếu tồn tại
            const oldImagePath = path.join(__dirname, '../../../backend/image', existingProduct[0].category, existingProduct[0].image);
            if (fs.existsSync(oldImagePath)) {
                fs.unlinkSync(oldImagePath);
            }
        }

        let query = 'UPDATE products SET';
        const params = [];

        if (name) { query += ' name = ?,'; params.push(name); }
        if (price) { query += ' price = ?,'; params.push(price); }
        if (description !== undefined) { query += ' description = ?,'; params.push(description); }
        if (amount !== undefined) { query += ' amount = ?,'; params.push(amount); }
        if (image) { query += ' image = ?,'; params.push(image); }
        if (category) { query += ' category = ?,'; params.push(category); }

        query = query.slice(0, -1); // Xoá dấu phẩy cuối
        query += ' WHERE id = ?';
        params.push(id);

        const [result] = await db.execute(query, params);
        res.status(200).json({ message: `Product ${id} updated with image` });
    } catch (error) {
        console.error('Error in updateProductWithImage:', error);
        res.status(500).json({
            error: error.message,
            stack: process.env.NODE_ENV === 'development' ? error.stack : undefined
        });
    }
};


// Xuất module
module.exports = {
    validateProduct,
    createProduct,
    getProducts,
    getProductById,
    updateProduct,
    deleteProduct,
    getProductBycategory,
    getProductByName,
    latestProduct,
    countByCategory,
    searchInCategory,
    processUpload,
    uploadProductImage,
    updateProductWithImage
};
