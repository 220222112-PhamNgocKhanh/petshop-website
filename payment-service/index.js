const http = require('http');
const sequelize = require('./src/utils/db'); // Kết nối cơ sở dữ liệu
const paymentRoutes = require('./src/routes/paymentRoutes'); // Định nghĩa các route

// Tạo server HTTP
const server = http.createServer((req, res) => {
    const url = new URL(req.url, `http://${req.headers.host}`);
    const pathname = url.pathname;
    const method = req.method;

    // Định tuyến các yêu cầu
    paymentRoutes(req, res, pathname, method);
});

// Đồng bộ cơ sở dữ liệu và khởi động server
const PORT = 8000; // Cổng server
sequelize
    .sync({ alter: true }) // Đồng bộ cơ sở dữ liệu (tự động cập nhật bảng nếu cần)
    .then(() => {
        console.log('Database synchronized successfully.');
        server.listen(PORT, () => {
            console.log(`Payment-service is running on http://localhost:${PORT}`);
        });
    })
    .catch((error) => {
        console.error('Error synchronizing database:', error);
    });