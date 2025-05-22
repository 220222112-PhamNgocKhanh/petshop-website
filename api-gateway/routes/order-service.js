const requestHandler = require('../utils/requestHandler');

const orderServiceRoutes = (req, res, url, method) => {
    const baseUrl = `http://${req.headers.host}${url}`;
    const parsedUrl = new URL(baseUrl);
    const pathname = parsedUrl.pathname;

    // 1. Đặt hàng
    if (pathname === '/order-service/place' && method === 'POST') {
        requestHandler(req, res, `http://localhost:4003${pathname}`, method);

    // 2. Lấy danh sách đơn hàng theo user (query string)
    } else if (url.startsWith('/order-service/user/') && method === 'GET') {
        // Đảm bảo rằng URL bắt đầu với '/order-service/user/:user_id'
        const userId = url.split('/')[3]; // Lấy user_id từ URL
        const fullUrl = `http://localhost:4003/order-service/user/${userId}`;
        requestHandler(req, res, fullUrl, method);

    // 3. Xem chi tiết đơn hàng (GET /order-service/:id)
    } else if (/^\/order-service\/\d+$/.test(pathname) && method === 'GET') {
        requestHandler(req, res, `http://localhost:4003${pathname}`, method);

    // 4. Cập nhật trạng thái đơn hàng (PUT /order-service/:id/status/:newStatus)
    } else if (/^\/order-service\/\d+\/status\/[^\/]+$/.test(pathname) && method === 'PUT') {
        requestHandler(req, res, `http://localhost:4003${pathname}`, method);

    // 5. Hủy đơn hàng (PUT /order-service/:id/cancel)
    } else if (/^\/order-service\/\d+\/cancel$/.test(pathname) && method === 'PUT') {
        requestHandler(req, res, `http://localhost:4003${pathname}`, method);
    
    // 6. Lấy tất cả đơn hàng
    } else if (pathname === '/order-service/all' && method === 'GET') {
        requestHandler(req, res, 'http://localhost:4003/order-service/all', method);

    // 7. Lấy danh sách đơn hàng theo trạng thái
    } else if (/^\/order-service\/status\/[^\/]+$/.test(pathname) && method === 'GET') {
        requestHandler(req, res, `http://localhost:4003${pathname}`, method);
    
    // 8. Đếm tổng số đơn hàng pending
    } else if (pathname === '/order-service/count/pending' && method === 'GET') {
        requestHandler(req, res, 'http://localhost:4003/order-service/count/pending', method);
    
    // 9. Đếm số đơn hàng theo thời gian (today, week, month, year)
    } else if (req.url.startsWith('/order-service/stats/count') && method === 'GET') {
        requestHandler(req, res, 'http://localhost:4003' + req.url);
    }
    else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Order service route not found' }));
    }
};

module.exports = orderServiceRoutes;
