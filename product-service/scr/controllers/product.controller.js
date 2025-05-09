const db = require('../db/db.js');
const { body, param, validationResult } = require('express-validator');

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
};
