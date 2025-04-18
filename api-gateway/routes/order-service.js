const requestHandler = require('../utils/requestHandler');

const orderServiceRoutes = (req, res, url, method) => {
    if (url === '/order-service/orders' && method === 'GET') {
        requestHandler(req, res, 'http://localhost:7000/orders'); // URL của order-service
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Order service route not found' }));
    }
};

module.exports = orderServiceRoutes;