const requestHandler = require('../utils/requestHandler');

const productServiceRoutes = (req, res, url, method) => {
    if (url === '/product-service/products' && method === 'GET') {
        requestHandler(req, res, 'http://localhost:6000/products'); // URL của product-service
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Product service route not found' }));
    }
};

module.exports = productServiceRoutes;