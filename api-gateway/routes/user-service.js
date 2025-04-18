const requestHandler = require('../utils/requestHandler');

const userServiceRoutes = (req, res, url, method) => {
    if (url === '/user-service/users' && method === 'GET') {
        // Lấy danh sách người dùng
        requestHandler(req, res, 'http://localhost:4000/user-service/users');
    } else if (url === '/user-service/register' && method === 'POST') {
        // Đăng ký người dùng
        requestHandler(req, res, 'http://localhost:4000/user-service/register');
    } else if (url === '/user-service/login' && method === 'POST') {
        // Đăng nhập người dùng
        requestHandler(req, res, 'http://localhost:4000/user-service/login');
    } else if (req.url.startsWith('/user-service/user/') && req.method === 'GET') {
        // Lấy thông tin người dùng theo ID
        requestHandler(req, res, 'http://localhost:4000' + req.url);
    } else if (url === '/user-service/verify' && method === 'POST') {
        // Xác thực email
        requestHandler(req, res, 'http://localhost:4000/user-service/verify');
    } else if (url === '/user-service/reset-password' && method === 'POST') {
        // Đặt lại mật khẩu
        requestHandler(req, res, 'http://localhost:4000/user-service/reset-password');
    } else if (url === '/user-service/forgot-password' && method === 'POST') {
        // Quên mật khẩu
        requestHandler(req, res, 'http://localhost:4000/user-service/forgot-password');
    } else if (url === '/user-service/update' && method === 'PUT') {
        // Cập nhật thông tin người dùng
        requestHandler(req, res, 'http://localhost:4000/user-service/update');
    } else if (url === '/user-service/admin-update' && method === 'PUT') {
        // Admin cập nhật thông tin người dùng
        requestHandler(req, res, 'http://localhost:4000/user-service/admin-update');
    } else if (url === '/user-service/delete' && method === 'DELETE') {
        // Xóa người dùng
        requestHandler(req, res, 'http://localhost:4000/user-service/delete');
    } else if (url === '/user-service/change-password' && method === 'PUT') {
        // Đổi mật khẩu
        requestHandler(req, res, 'http://localhost:4000/user-service/change-password');
    } else {
        // Route không tồn tại
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'User service route not found' }));
    }
};

module.exports = userServiceRoutes;