const userController = require('../controllers/userController');

const userRoutes = (req, res, pathname, method) => {
    if (pathname === '/user-service/register' && method === 'POST') {
        userController.register(req, res);
    } else if (pathname === '/user-service/login' && method === 'POST') {
        userController.login(req, res);
    } else if (pathname === '/user-service/users' && method === 'GET') {
        userController.getUsers(req, res);
    } else if (pathname === '/user-service/update' && method === 'PUT') {
        userController.updateUser(req, res);
    } else if (pathname === '/user-service/admin-update' && method === 'PUT') {
        userController.adminUpdateUser(req, res); // Route mới cho adminUpdateUser
    } else if (pathname === '/user-service/delete' && method === 'DELETE') {
        userController.deleteUser(req, res);
    } else if (method === 'GET' && pathname.startsWith('/user-service/user/')) {
        return userController.getUserById(req, res);
    } else if (pathname === '/user-service/reset-password' && method === 'POST') {
        userController.resetPassword(req, res);
    } else if (pathname === '/user-service/forgot-password' && method === 'POST') {
        userController.forgotPassword(req, res);
    } else if (pathname === '/user-service/change-password' && method === 'PUT') {
        userController.changePassword(req, res);
    }else if (pathname === '/user-service/change-avatar' && method === 'POST') {
        userController.changeAvatar(req, res);
    }else if (pathname.startsWith('/user-service/avatar/') && method === 'GET') {
        userController.getAvatar(req, res);
    }else if (pathname.startsWith('/user-service/users/email/') && method === 'GET') {
        userController.getUserByEmail(req, res);
    } else if (pathname.startsWith('/user-service/users/username/') && method === 'GET') {
        userController.getUserIdByUsername(req, res);
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'User service route not found' }));
    }
};

module.exports = userRoutes;