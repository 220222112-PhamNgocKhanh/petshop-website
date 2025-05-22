const rateLimit = require('express-rate-limit');

// Giới hạn tạo notification: 100 requests/15 phút
const createNotificationLimiter = rateLimit({
    windowMs: 15 * 60 * 1000, // 15 phút
    max: 100, // Tối đa 100 requests
    message: {
        success: false,
        message: 'Quá nhiều requests, vui lòng thử lại sau 15 phút'
    },
    standardHeaders: true, // Trả về thông tin rate limit trong headers
    legacyHeaders: false
});

// Giới hạn tổng quát: 1000 requests/15 phút
const generalLimiter = rateLimit({
    windowMs: 15 * 60 * 1000,
    max: 1000,
    message: {
        success: false,
        message: 'Quá nhiều requests từ IP này'
    }
});

module.exports = {
    createNotificationLimiter,
    generalLimiter
};