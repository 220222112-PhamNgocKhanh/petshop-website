const paymentController = require('../controllers/paymentController');
const verifyToken = require('../utils/authMiddleware');
const authorizeRole = require('../utils/authorizeRole');

const paymentRoutes = (req, res, pathname, method) => {
    if (pathname === '/payment-service/payments' && method === 'POST') {
        // Tạo thanh toán mới (chỉ user hoặc admin)
        verifyToken(req, res, () => {
            authorizeRole('user', 'admin')(req, res, () => {
                paymentController.createPayment(req, res);
            });
        });
    } else if (pathname === '/payment-service/payments' && method === 'GET') {
        // Lấy danh sách thanh toán (chỉ admin)
        verifyToken(req, res, () => {
            authorizeRole('admin')(req, res, () => {
                paymentController.getPayments(req, res);
            });
        });
    } else if (pathname.startsWith('/payment-service/payments/') && method === 'GET') {
        // Lấy thông tin thanh toán theo ID (chỉ user hoặc admin)
        const paymentId = pathname.split('/').pop();
        verifyToken(req, res, () => {
            authorizeRole('user', 'admin')(req, res, () => {
                paymentController.getPaymentById(req, res, paymentId);
            });
        });
    } else if (pathname.startsWith('/payment-service/payments/') && method === 'PUT') {
        // Cập nhật trạng thái thanh toán (chỉ admin)
        const paymentId = pathname.split('/').pop();
        verifyToken(req, res, () => {
            authorizeRole('admin')(req, res, () => {
                paymentController.updatePaymentStatus(req, res, paymentId);
            });
        });
    } else {
        // Route không tồn tại
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Payment service route not found' }));
    }
};

module.exports = paymentRoutes;