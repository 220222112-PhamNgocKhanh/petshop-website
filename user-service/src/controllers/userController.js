const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const User = require('../models/User');
const parseRequestBody = require('../utils/parseRequestBody');
const fs = require('fs');
const path = require('path');
const { sendNotification } = require('../utils/requestHelper');

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
exports.register = async (req, res) => {
    parseRequestBody(req, res, async (body) => {
        const { username, password, email } = body;
        if (!username || !password || !email) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Vui lòng điền đầy đủ thông tin' }));
        }

        try {
            const hashedPassword = await bcrypt.hash(password, 10);
            const newUser = await User.create({
                username,
                email,
                password_hash: hashedPassword,
                role: 'user'
            });

            // 📌 Kiểm tra xem request có thực sự gửi đi không
            console.log('📩 Đang gửi thông báo:', { type: 'accountCreated', to: email, name: username });

            // ✅ Gửi email thông báo đăng ký tài khoản mới (chờ phản hồi)
            await sendNotification({
                type: 'accountCreated',
                to: email,
                name: username
            });

            res.writeHead(201, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ 
                message: 'Đăng ký tài khoản thành công', 
                user: newUser 
            }));
        } catch (error) {
            console.error('Register error:', error);
            let errorMessage = 'Đã có lỗi xảy ra';
            
            if (error.name === 'SequelizeUniqueConstraintError') {
                if (error.fields.username) {
                    errorMessage = 'Tên đăng nhập đã tồn tại';
                } else if (error.fields.email) {
                    errorMessage = 'Email đã được sử dụng';
                }
            }
            
            res.writeHead(400, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: errorMessage }));
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
                return res.end(JSON.stringify({ message: 'Tên đăng nhập hoặc mật khẩu không đúng' }));
            }

            const isValid = await bcrypt.compare(password, user.password_hash);
            if (!isValid) {
                res.writeHead(401, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Tên đăng nhập hoặc mật khẩu không đúng' }));
            }

            const token = jwt.sign(
                {
                    user_id: user.user_id,
                    username: user.username,
                    role: user.role,
                },
                process.env.JWT_SECRET || 'petshop',
                { expiresIn: '1h' }
            );

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Đăng nhập thành công', token }));
        } catch (error) {
            console.error('Login error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Lỗi hệ thống, vui lòng thử lại sau' }));
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
        const users = await User.findAll({
            where: {
                role: 'user' // Chỉ lấy người dùng có role là user
            }
        });
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

    if (!decoded) {
        res.writeHead(401, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Vui lòng đăng nhập' }));
    }

    try {
        const user = await User.findByPk(id);
        if (!user) {
            res.writeHead(404, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'User not found' }));
        }

        // Kiểm tra nếu user là admin thì không cho phép xem
        if (user.role === 'admin') {
            res.writeHead(403, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Access denied' }));
        }

        // Kiểm tra quyền truy cập
        if (decoded.user_id !== Number(id) && decoded.role !== 'admin') {
            res.writeHead(403, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Permission denied' }));
        }

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(user));
    } catch (error) {
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};
// Lấy user theo email
exports.getUserByEmail = async (req, res) => {
    const decoded = exports.verifyToken(req);
    const email = req.url.split('/email/').pop();

    if (!decoded) {
        res.writeHead(401, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ 
            message: 'Vui lòng đăng nhập để thực hiện thao tác này'
        }));
    }

    try {
        const user = await User.findOne({
            where: { email: email }
        });

        if (!user) {
            res.writeHead(404, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ 
                message: 'Không tìm thấy người dùng với email này'
            }));
        }

        // Kiểm tra nếu user là admin thì không cho phép xem
        if (user.role === 'admin') {
            res.writeHead(403, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Access denied' }));
        }

        // Kiểm tra quyền truy cập
        if (decoded.role !== 'admin' && decoded.email !== email) {
            res.writeHead(403, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ 
                message: 'Bạn không có quyền truy cập thông tin này'
            }));
        }

        // Loại bỏ thông tin nhạy cảm trước khi gửi
        const userResponse = {
            user_id: user.user_id,
            email: user.email,
            username: user.username,
            address: user.address,
            role: user.role,
            created_at: user.created_at
        };

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify(userResponse));

    } catch (error) {
        console.error('Error in getUserByEmail:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ 
            message: 'Đã xảy ra lỗi khi tìm kiếm người dùng',
            error: error.message 
        }));
    }
};

// Cập nhật user (chính chủ )
exports.updateUser = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded) {
        res.writeHead(401, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Vui lòng đăng nhập lại' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { email, address } = body;
        try {
            const user = await User.findByPk(decoded.user_id);
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Không tìm thấy thông tin người dùng' }));
            }

            try {
                await user.update({
                    email: email || user.email,
                    address: address || user.address
                });

                res.writeHead(200, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ message: 'Cập nhật thông tin thành công', user }));
            } catch (updateError) {
                if (updateError.name === 'SequelizeUniqueConstraintError') {
                    res.writeHead(400, { 'Content-Type': 'application/json' });
                    return res.end(JSON.stringify({ 
                        message: 'Email đã được sử dụng bởi tài khoản khác',
                        code: 'ER_DUP_ENTRY',
                        sqlMessage: updateError.message
                    }));
                }
                throw updateError;
            }
        } catch (error) {
            console.error('Update error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Lỗi cập nhật thông tin, vui lòng thử lại' }));
        }
    });
};
// Admin cập nhật thông tin user
exports.adminUpdateUser = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Bạn không có quyền thực hiện thao tác này' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { username, email, address } = body;
        if (!username) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Vui lòng cung cấp username' }));
        }

        try {
            const user = await User.findOne({ 
                where: { username: username }
            });

            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Không tìm thấy người dùng' }));
            }

            // Kiểm tra email mới có trùng với email của user khác không
            if (email && email !== user.email) {
                const existingUser = await User.findOne({ where: { email: email } });
                if (existingUser) {
                    res.writeHead(400, { 'Content-Type': 'application/json' });
                    return res.end(JSON.stringify({ 
                        message: 'Email đã được sử dụng bởi tài khoản khác',
                        code: 'ER_DUP_ENTRY'
                    }));
                }
            }

            // Cập nhật thông tin
            await user.update({
                email: email || user.email,
                address: address || user.address
            });

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ 
                message: 'Cập nhật thông tin thành công',
                user: {
                    username: user.username,
                    email: user.email,
                    address: user.address,
                    role: user.role
                }
            }));
        } catch (error) {
            console.error('Admin update error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ 
                message: 'Đã xảy ra lỗi khi cập nhật thông tin',
                error: error.message 
            }));
        }
    });
};

// Xóa user (admin)
exports.deleteUser = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Bạn không có quyền thực hiện thao tác này' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { username } = body;
        if (!username) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Vui lòng cung cấp username' }));
        }

        try {
            const user = await User.findOne({ where: { username: username } });
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Không tìm thấy người dùng' }));
            }

            await user.destroy();
            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Xóa người dùng thành công' }));
        } catch (error) {
            console.error('Delete error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ 
                message: 'Đã xảy ra lỗi khi xóa người dùng',
                error: error.message 
            }));
        }
    });
};

// Reset mật khẩu (admin)
exports.resetPassword = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Bạn không có quyền thực hiện thao tác này' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { username, new_password } = body;
        if (!username || !new_password) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Vui lòng cung cấp đầy đủ thông tin' }));
        }

        try {
            const user = await User.findOne({ where: { username: username } });
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Không tìm thấy người dùng' }));
            }

            user.password_hash = await bcrypt.hash(new_password, 10);
            await user.save();

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Đặt lại mật khẩu thành công' }));
        } catch (error) {
            console.error('Reset password error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ 
                message: 'Đã xảy ra lỗi khi đặt lại mật khẩu',
                error: error.message 
            }));
        }
    });
};

// Người dùng đổi mật khẩu
exports.changePassword = (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!decoded) {
        res.writeHead(401, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Vui lòng đăng nhập lại' }));
    }

    parseRequestBody(req, res, async (body) => {
        const { old_password, new_password } = body;
        if (!old_password || !new_password) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Vui lòng nhập đầy đủ mật khẩu cũ và mới' }));
        }

        try {
            const user = await User.findByPk(decoded.user_id);
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Không tìm thấy thông tin người dùng' }));
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
            res.end(JSON.stringify({ message: 'Lỗi đổi mật khẩu, vui lòng thử lại sau' }));
        }
    });
};


// Quên mật khẩu
exports.forgotPassword = (req, res) => {
    parseRequestBody(req, res, async (body) => {
        const { email } = body;
        if (!email) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ message: 'Vui lòng nhập email' }));
        }

        try {
            const user = await User.findOne({ where: { email } });
            if (!user) {
                res.writeHead(404, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Email không tồn tại trong hệ thống' }));
            }

            // ✅ Gửi email thông báo mật khẩu mới
            sendNotification({
                type: 'passwordReset',
                to: email,
                name: user.username,
                link: `https://example.com/reset-password?token=${Date.now()}`
            });

            const newPassword = generateRandomPassword();
            user.password_hash = await bcrypt.hash(newPassword, 10);
            await user.save();

            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ 
                message: 'Mật khẩu mới đã được tạo', 
                new_password: newPassword 
            }));
        } catch (error) {
            console.error('Forgot password error:', error);
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Lỗi khôi phục mật khẩu, vui lòng thử lại sau' }));
        }
    });
};
//tao mat khau ngau nhien
function generateRandomPassword(length = 8) {
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return Array.from({ length }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
}

// Lấy user ID theo username
exports.getUserIdByUsername = async (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Bạn không có quyền thực hiện thao tác này' }));
    }

    // Lấy username từ URL
    const username = req.url.split('/username/').pop();

    try {
        const user = await User.findOne({
            where: { username: username }
        });
        
        if (!user) {
            res.writeHead(404, { 'Content-Type': 'application/json' });
            return res.end(JSON.stringify({ 
                message: 'Không tìm thấy người dùng với username này'
            }));
        }
        
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ 
            user_id: user.user_id,
            username: user.username
        }));

    } catch (error) {
        console.error('Error in getUserIdByUsername:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ 
            message: 'Đã xảy ra lỗi khi tìm kiếm user_id',
            error: error.message 
        }));
    }
};

// Lấy số lượng người dùng (không tính admin)
exports.getUserCount = async (req, res) => {
    const decoded = exports.verifyToken(req);
    if (!exports.checkRole(decoded, 'admin')) {
        res.writeHead(403, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Access denied' }));
    }

    try {
        const count = await User.count({
            where: {
                role: 'user'
            }
        });
        
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ count }));
    } catch (error) {
        console.error('Error in getUserCount:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal server error' }));
    }
};

