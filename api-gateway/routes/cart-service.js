const requestHandler = require('../utils/requestHandler');

const cartServiceRoutes = (req, res, url, method) => {
    if (url === '/cart-service/cart' && method === 'GET') {
        // Lấy giỏ hàng của user (truyền userId qua query)
        requestHandler(req, res, 'http://localhost:3002/cart-service/cart');
    } else if (url === '/cart-service/cart' && method === 'POST') {
        // Thêm sản phẩm vào giỏ hàng
        requestHandler(req, res, 'http://localhost:3002/cart-service/cart');
    } else if (url === '/cart-service/cart' && method === 'PUT') {
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        requestHandler(req, res, 'http://localhost:3002/cart-service/cart');
    } else if (url === '/cart-service/cart' && method === 'DELETE') {
        // Xóa toàn bộ giỏ hàng của user
        requestHandler(req, res, 'http://localhost:3002/cart-service/cart');
    } else if (req.url.startsWith('/cart-service/cart/item') && method === 'DELETE') {
        // Xóa một sản phẩm khỏi giỏ hàng (truyền userId và productId qua query)
        requestHandler(req, res, 'http://localhost:3002' + req.url);
    } else {
        // Route không tồn tại
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Cart service route not found' }));
    }
};

module.exports = cartServiceRoutes;
