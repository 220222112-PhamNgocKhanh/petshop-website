const User = require('../models/UserModel');
const bcrypt = require('bcrypt');

exports.login = async (req, res) => {
    const { email, password } = req.body;

    try {
        const user = await User.findOne({ where: { email } });

        // So sánh mật khẩu không mã hóa
        if (user && user.password_hash === password) {
            res.json({
                status: 'success',
                message: 'Login successful',
                data: {
                    id: user.id,
                    username: user.username,
                    email: user.email,
                    role: user.role,
                },
            });
        } else {
            res.status(401).json({ status: 'error', message: 'Invalid credentials' });
        }
    } catch (error) {
        res.status(500).json({ status: 'error', message: 'Internal server error', error: error.message });
    }
};