const userController = require('../controllers/userController');

const userRoutes = (req, res, pathname, method) => {
    if (pathname === '/user-service/register' && method === 'POST') {
        userController.register(req, res);
    }
    else if (pathname.startsWith('/user-service/user/') && method === 'GET') {
        userController.getUserById(req, res);
    }
     else if (pathname === '/user-service/login' && method === 'POST') {
        userController.login(req, res);
    } else if (pathname === '/user-service/users' && method === 'GET') {
        userController.getUsers(req, res);
    } else if (pathname === '/user-service/users/count' && method === 'GET') {
        userController.getUserCount(req, res);
    } else if (pathname === '/user-service/update' && method === 'PUT') {
        userController.updateUser(req, res);
    } else if (pathname === '/user-service/admin-update' && method === 'PUT') {
        userController.adminUpdateUser(req, res);
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
    } else if (pathname.startsWith('/user-service/users/email/') && method === 'GET') {
        userController.getUserByEmail(req, res);
    } else if (pathname.startsWith('/user-service/users/username/') && method === 'GET') {
        userController.getUserIdByUsername(req, res);
    } else if (pathname === '/user-service/stats/new-users' && method === 'GET') {
        userController.getNewUserStats(req, res);
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'User service route not found' }));
    }
};

module.exports = userRoutes;