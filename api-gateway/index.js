const http = require('http');
const userServiceRoutes = require('./routes/user-service');
const blogServiceRoutes = require('./routes/blog-service');
const productServiceRoutes = require('./routes/product-service');
const orderServiceRoutes = require('./routes/order-service');
const paymentServiceRoutes = require('./routes/payment-service');
const notificationServiceRoutes = require('./routes/notification-service');

// Tạo server
const server = http.createServer((req, res) => {
    const url = req.url;
    const method = req.method;

    // Thêm header CORS
    res.setHeader('Access-Control-Allow-Origin', '*'); // Cho phép tất cả các nguồn
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'); // Các phương thức được phép
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization'); // Các header được phép

    // Xử lý preflight request (OPTIONS)
    if (method === 'OPTIONS') {
        res.writeHead(204); // No Content
        return res.end();
    }

    // Định tuyến các request
    if (url.startsWith('/user-service')) {
        userServiceRoutes(req, res, url, method);
    } else if (url.startsWith('/blog-service')) {
        blogServiceRoutes(req, res, url, method);
    } else if (url.startsWith('/product-service')) {
        productServiceRoutes(req, res, url, method);
    } else if (url.startsWith('/order-service')) {
        orderServiceRoutes(req, res, url, method);
    } else if (url.startsWith('/payment-service')) {
        paymentServiceRoutes(req, res, url, method);
    } else if (url.startsWith('/notification-service')) {
        notificationServiceRoutes(req, res, url, method);
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Route not found' }));
    }
});

// Lắng nghe server
const PORT = 3000;
server.listen(PORT, () => {
    console.log(`API Gateway is running on http://localhost:${PORT}`);
});