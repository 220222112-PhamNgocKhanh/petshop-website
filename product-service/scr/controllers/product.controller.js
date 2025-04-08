const db = require('../db/db.js'); // Import the database connection
const { body, param, validationResult } = require('express-validator');

const validateProduct = [
    body('name').notEmpty().withMessage('Name is required'),
    body('price').isFloat({ min: 0 }).withMessage('Price must be a positive number'),
    body('category_id').isInt().withMessage('Category ID must be an integer'),
    (req, res, next) => {
        const errors = validationResult(req);
        if (!errors.isEmpty()) {
            return res.status(400).json({ errors: errors.array() });
        }
        next();
    },
];

const createProduct = async (req, res) => {
    const { name, price, description, category_id } = req.body;
    try {
        const [result] = await db.execute(
            'INSERT INTO products (name, price, description, category_id) VALUES (?, ?, ?, ?)',
            [name, price, description, category_id]
        );
        res.status(201).json({ message: 'Product created', productId: result.insertId });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

const updateProduct = async (req, res) => {
    const { id } = req.params;
    const { name, price, description, category_id } = req.body;

    // Xây dựng câu lệnh SQL động
    let query = 'UPDATE products SET';
    const params = [];
    
    if (name) {
        query += ' name = ?,';
        params.push(name);
    }
    if (price) {
        query += ' price = ?,';
        params.push(price);
    }
    if (description) {
        query += ' description = ?,';
        params.push(description);
    }
    if (category_id) {
        query += ' category_id = ?,';
        params.push(category_id);
    }

    // Xóa dấu phẩy cuối cùng
    query = query.slice(0, -1);
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

const getProducts = async (req, res) => {
    const { limit = 10, offset = 0, search = '', min_price, max_price, category_id } = req.query;
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
    if (category_id) {
        query += ' AND category_id = ?';
        params.push(category_id);
    }

    query += ' LIMIT ? OFFSET ?';
    params.push(parseInt(limit), parseInt(offset));

    try {
        const [products] = await db.execute(query, params);
        res.status(200).json({ products });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

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

const getProductsByCategory = async (req, res) => {
    const { categoryId } = req.params;
    try {
        const [products] = await db.execute(
            'SELECT * FROM products WHERE category_id = ?',
            [categoryId]
        );
        res.status(200).json({ products });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

// Export hàm
module.exports = {
    createProduct,
    getProducts,
    getProductById,
    updateProduct,
    deleteProduct,
    getProductsByCategory,
};