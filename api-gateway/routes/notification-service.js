const requestHandler = require('../utils/requestHandler');

const notificationServiceRoutes = (req, res, url, method) => {
    // Route cho việc gửi email
    if (url === '/notification-service/send-email' && method === 'POST') {
        requestHandler(req, res, 'http://localhost:3005/send-email');
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ 
            success: false,
            message: 'Notification service route not found' 
        }));
    }
};

module.exports = notificationServiceRoutes;