const requestHandler = require('../utils/requestHandler');

const blogServiceRoutes = (req, res, url, method) => {
    if (url === '/blog-service/posts' && method === 'GET') {
        requestHandler(req, res, 'http://localhost:5000/posts'); // URL của blog-service
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Blog service route not found' }));
    }
};

module.exports = blogServiceRoutes;