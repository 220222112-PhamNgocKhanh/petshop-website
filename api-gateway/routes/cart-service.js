const requestHandler = require('../utils/requestHandler');

const cartServiceRoutes = (req, res, url, method) => {
    const parts = url.split('/').filter(Boolean);

    // Route: GET /cart-service/cart/:userId - Lấy giỏ hàng của người dùng
    if (parts[0] === 'cart-service' && parts[1] === 'cart' && parts.length === 3 && method === 'GET') {
        const userId = parts[2];
        requestHandler(req, res, `http://localhost:3002/cart-service/${userId}`);
    }
    
    // Route: POST /cart-service/cart/:userId - Thêm sản phẩm vào giỏ hàng
    else if (parts[0] === 'cart-service' && parts[1] === 'cart' && parts.length === 3 && method === 'POST') {
        const userId = parts[2];
        requestHandler(req, res, `http://localhost:3002/cart-service/${userId}`);
    }
    
    // Route: PUT /cart-service/cart/:userId - Cập nhật số lượng sản phẩm trong giỏ hàng
    else if (parts[0] === 'cart-service' && parts[1] === 'cart' && parts.length === 3 && method === 'PUT') {
        const userId = parts[2];
        requestHandler(req, res, `http://localhost:3002/cart-service/${userId}`);
    }
    
    // Route: DELETE /cart-service/cart/:userId/:productId - Xóa một sản phẩm khỏi giỏ hàng
    else if (parts[0] === 'cart-service' && parts[1] === 'cart' && parts.length === 4 && method === 'DELETE') {
        const userId = parts[2];
        const productId = parts[3];
        requestHandler(req, res, `http://localhost:3002/cart-service/${userId}/${productId}`);
    }
    
    // Nếu không khớp bất kỳ route nào ở trên
    else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Cart service route not found' }));
    }
};

module.exports = cartServiceRoutes;
