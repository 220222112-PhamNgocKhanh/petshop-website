const requestHandler = require('../utils/requestHandler');

const paymentServiceRoutes = (req, res, url, method) => {
    if (url === '/payment-service/payments' && method === 'POST') {
        // Tạo thanh toán mới
        requestHandler(req, res, 'http://localhost:8000/payment-service/payments');
    } else if (url === '/payment-service/payments' && method === 'GET') {
        // Lấy danh sách thanh toán
        requestHandler(req, res, 'http://localhost:8000/payment-service/payments');
    } else if (url.startsWith('/payment-service/payments/') && method === 'GET') {
        // Lấy thông tin thanh toán theo ID
        requestHandler(req, res, `http://localhost:8000${url}`);
    } else if (url.startsWith('/payment-service/payments/') && method === 'PUT') {
        // Cập nhật trạng thái thanh toán
        requestHandler(req, res, `http://localhost:8000${url}`);
    } else if (url === '/payment-service/payments/total-successful' && method === 'GET') {
        // Lấy tổng giá trị thanh toán thành công
        requestHandler(req, res, 'http://localhost:8000/payment-service/payments/total-successful');
    } else {
        // Route không tồn tại
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Payment service route not found' }));
    }
};

module.exports = paymentServiceRoutes;