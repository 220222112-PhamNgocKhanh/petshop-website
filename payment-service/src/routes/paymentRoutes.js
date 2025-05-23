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
        paymentController.getPayments(req, res);;
    } else if (pathname.startsWith('/payment-service/payments/') && method === 'GET') {
        // Lấy thông tin thanh toán theo OrderID (chỉ user hoặc admin)
        const order_id = pathname.split('/').pop();
        paymentController.getPaymentByOrderId(req, res, order_id);
    } else if (pathname.startsWith('/payment-service/payments/') && method === 'PUT') {
        // Cập nhật trạng thái thanh toán (chỉ admin)
        const paymentId = pathname.split('/').pop();
        paymentController.updatePaymentStatus(req, res, paymentId);
    } else if (pathname === '/payment-service/payments/total-successful' && method === 'GET') {
        paymentController.getTotalSuccessfulPayments(req, res);
    } else {
        // Route không tồn tại
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Payment service route not found' }));
    }
    
};

module.exports = paymentRoutes;