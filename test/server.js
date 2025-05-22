const mysql = require('mysql2/promise');
require('dotenv').config();

// Tạo pool connection để tối ưu hiệu suất
// Pool giúp tái sử dụng kết nối thay vì tạo mới mỗi lần
const pool = mysql.createPool({
    host: process.env.DB_HOST,           // Địa chỉ MySQL server
    port: process.env.DB_PORT,           // Port MySQL (mặc định 3306)
    user: process.env.DB_USER,           // Username MySQL
    password: process.env.DB_PASSWORD,   // Password MySQL
    database: process.env.DB_NAME,       // Tên database
    waitForConnections: true,            // Chờ kết nối nếu pool đầy
    connectionLimit: 10,                 // Tối đa 10 kết nối đồng thời
    queueLimit: 0                        // Không giới hạn queue
});

// Hàm test kết nối database
const testConnection = async () => {
    try {
        const connection = await pool.getConnection();
        console.log('✅ Kết nối MySQL thành công!');
        connection.release(); // Trả kết nối về pool
    } catch (error) {
        console.error('❌ Lỗi kết nối MySQL:', error.message);
        process.exit(1); // Thoát ứng dụng nếu không kết nối được DB
    }
};

module.exports = {
    pool,
    testConnection
};
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
require('dotenv').config();

// Import các modules
const { testConnection } = require('./config/database');
const { testEmailConnection } = require('./config/email');
const notificationRoutes = require('./routes/notificationRoutes');
const errorHandler = require('./middleware/errorHandler');
const { generalLimiter } = require('./middleware/rateLimiter');
const EmailProcessor = require('./jobs/EmailProcessor');

// Tạo Express app
const app = express();
const PORT = process.env.PORT || 3003;