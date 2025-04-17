const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const User = require('../models/User');
const parseRequestBody = require('../utils/parseRequestBody');

// Xác thực token từ header Authorization
exports.verifyToken = (req) => {
    const authHeader = req.headers.authorization;
    if (!authHeader) return null;
    const token = authHeader.split(' ')[1];
    try {
        const decoded = jwt.verify(token, process.env.JWT_SECRET || 'petshop');
        return decoded;
    } catch (err) {
        console.error('Token Verification Error:', err);
        return null;
    }
};


// Kiểm tra role
exports.checkRole = (decoded, role) => decoded && decoded.role === role;

// Đăng ký
exports.register = (req, res) => {
    parseRequestBody(req, res, async (body) => {
        const { username, password, email } = body;
        if (!username || !password || !email) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Missing fields' }));
        }

        try {
            const hashedPassword = await bcrypt.hash(password, 10);
            const newUser = await User.create({
                username,
                email,
                password_hash: hashedPassword,
                role: 'user'
            });

            res.writeHead(201, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'User registered successfully', user: newUser }));
        } catch (error) {
            console.error('Register error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

// Đăng nhập
exports.login = (req, res) => {
    parseRequestBody(req, res, async (body) => {
        const { username, password } = body;
        try {
            const user = await User.findOne({ where: { username } });
            if (!user) {
                res.writeHead(401, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Invalid credentials' }));
            }

            const isValid = await bcrypt.compare(password, user.password_hash);
            if (!isValid) {
                res.writeHead(401, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Invalid credentials' }));
            }

            const token = jwt.sign(
                {
                    user_id: user.user_id,
                    username: user.username,
                    role: user.role
                },
                process.env.JWT_SECRET || 'petshop',
                { expiresIn: '1h' }
            );
            

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Login successful', token }));
        } catch (error) {
            console.error('Login error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

// Lấy danh sách user (admin)
exports.getUsers = async (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Access denied' }));
    }

    try {
        const users = await User.findAll();
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(users));
    } catch (error) {
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};

// Lấy user theo ID
exports.getUserById = async (req, res) => {
    const decoded = exports.verifyToken(req);
    const id = req.url.split('/').pop();

    if (!decoded || (decoded.user_id !== Number(id) && decoded.role !== 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Permission denied' }));
    }

    try {
        const user = await User.findByPk(id);
        if (!user) {
            res.writeHead(404, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'User not found' }));
        }

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(user));
    } catch (error) {
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};

// Cập nhật user (chính chủ )
exports.updateUser = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded) {
        res.writeHead(401, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Unauthorized' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { email, address } = body;
        try {
            const user = await User.findByPk(decoded.user_id); // Sử dụng user_id thay vì username
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'User not found' }));
            }

            await user.update({
                email: email || user.email,
                address: address || user.address
            });

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'User updated successfully', user }));
        } catch (error) {
            console.error('Update error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};
// Admin cập nhật thông tin user
exports.adminUpdateUser = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Access denied' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { user_id, email, address, role } = body;
        if (!user_id) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'User ID is required' }));
        }

        try {
            const user = await User.findByPk(user_id);
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'User not found' }));
            }

            await user.update({
                email: email || user.email,
                address: address || user.address,
                role: role || user.role
            });

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'User updated successfully', user }));
        } catch (error) {
            console.error('Admin update error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

// Xóa user (admin)
exports.deleteUser = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Access denied' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { user_id } = body;
        try {
            const user = await User.findByPk(user_id);
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'User not found' }));
            }

            await user.destroy();
            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'User deleted successfully' }));
        } catch (error) {
            console.error('Delete error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

// Admin reset mật khẩu
exports.resetPassword = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Access denied' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { user_id, new_password } = body;
        try {
            const user = await User.findByPk(user_id);
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'User not found' }));
            }

            user.password_hash = await bcrypt.hash(new_password, 10);
            await user.save();

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Password reset successfully' }));
        } catch (error) {
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

// Người dùng đổi mật khẩu
exports.changePassword = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded) {
        res.writeHead(401, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Unauthorized' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { old_password, new_password } = body;
        try {
            const user = await User.findByPk(decoded.user_id);
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'User not found' }));
            }

            const isValid = await bcrypt.compare(old_password, user.password_hash);
            if (!isValid) {
                res.writeHead(401, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Mật khẩu hiện tại không đúng' }));
            }

            user.password_hash = await bcrypt.hash(new_password, 10);
            await user.save();

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Đổi mật khẩu thành công' }));
        } catch (error) {
            console.error('Change password error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};


// Quên mật khẩu
exports.forgotPassword = (req, res) => {
    parseRequestBody(req, res, async (body) => {
        const { email } = body; // Thay đổi từ username sang email
        try {
            const user = await User.findOne({ where: { email } }); // Tìm user theo email
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'User not found' }));
            }

            const newPassword = generateRandomPassword();
            user.password_hash = await bcrypt.hash(newPassword, 10);
            await user.save();

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Password reset successfully', new_password: newPassword }));
        } catch (error) {
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal server error' }));
        }
    });
};

function generateRandomPassword(length = 8) {
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return Array.from({ length }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
}
