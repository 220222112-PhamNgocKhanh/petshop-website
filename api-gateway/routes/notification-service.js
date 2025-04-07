const requestHandler = require('../utils/requestHandler');

const notificationServiceRoutes = (req, res, url, method) => {
    if (url === '/notification-service/notifications' && method === 'GET') {
        requestHandler(req, res, 'http://localhost:9000/notifications'); // URL của notification-service
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Notification service route not found' }));
    }
};

module.exports = notificationServiceRoutes;