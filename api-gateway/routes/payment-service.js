const requestHandler = require('../utils/requestHandler');

const paymentServiceRoutes = (req, res, url, method) => {
    if (url === '/payment-service/payments' && method === 'POST') {
        requestHandler(req, res, 'http://localhost:8000/payments'); // URL của payment-service
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Payment service route not found' }));
    }
};

module.exports = paymentServiceRoutes;