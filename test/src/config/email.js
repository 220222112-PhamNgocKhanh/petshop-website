const nodemailer = require('nodemailer');
require('dotenv').config();

// Tạo transporter - "người vận chuyển" email
const transporter = nodemailer.createTransporter({
    host: process.env.EMAIL_HOST,        // SMTP server của Gmail
    port: process.env.EMAIL_PORT,        // Port 587 cho TLS
    secure: false,                       // false cho port 587, true cho 465
    auth: {
        user: process.env.EMAIL_USER,    // Email gửi
        pass: process.env.EMAIL_PASSWORD // App password (không phải mật khẩu thường)
    },
    tls: {
        rejectUnauthorized: false        // Bỏ qua lỗi certificate
    }
});

// Hàm test gửi email
const testEmailConnection = async () => {
    try {
        await transporter.verify();
        console.log('✅ Kết nối email server thành công!');
    } catch (error) {
        console.error('❌ Lỗi kết nối email server:', error.message);
    }
};

module.exports = {
    transporter,
    testEmailConnection
};
