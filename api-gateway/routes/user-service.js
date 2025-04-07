const requestHandler = require('../utils/requestHandler');

const userServiceRoutes = (req, res, url, method) => {
    if (url === '/user-service/users' && method === 'GET') {
        requestHandler(req, res, 'http://localhost:4000/users'); // URL của user-service
    } else if (url === '/user-service/register' && method === 'POST') {
        requestHandler(req, res, 'http://localhost:4000/register'); // URL của user-service
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'User service route not found' }));
    }
};

module.exports = userServiceRoutes;