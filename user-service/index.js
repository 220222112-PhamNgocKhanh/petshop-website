const http = require('http');
const url = require('url');
const userRoutes = require('./src/routes/userRoutes');
const sequelize = require('./src/utils/db'); // Kết nối database
require('dotenv').config();

// Đồng bộ model với database
sequelize.sync({ alter: true }) // Tự động tạo bảng nếu chưa tồn tại
    .then(() => console.log('Database synchronized.'))
    .catch((err) => console.error('Error synchronizing database:', err));

// Tạo server HTTP
const server = http.createServer((req, res) => {
    const parsedUrl = url.parse(req.url, true);
    const method = req.method;
    const pathname = parsedUrl.pathname;

    // Thêm header CORS
    res.setHeader('Access-Control-Allow-Origin', '*'); // Cho phép tất cả các domain
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

    // Xử lý preflight request (OPTIONS)
    if (method === 'OPTIONS') {
        res.writeHead(204); // No Content
        res.end();
        return;
    }

    // Xử lý route cho user-service
    if (pathname.startsWith('/user-service')) {
        userRoutes(req, res, pathname, method);
    } else {
        // Route không tồn tại
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Route not found' }));
    }
});

// Khởi động server
const PORT = process.env.PORT || 4000;
server.listen(PORT, () => {
    console.log(`User-service is running on http://localhost:${PORT}`);
});