const express = require('express');
const router = express.Router();
const NotificationController = require('../controllers/NotificationController');

// Middleware log request (ghi log mỗi request)
const logRequest = (req, res, next) => {
    console.log(`📝 ${req.method} ${req.originalUrl} - ${new Date().toISOString()}`);
    next(); // Tiếp tục xử lý request
};

// Áp dụng middleware cho tất cả routes
router.use(logRequest);

// =============================================
// ĐỊNH NGHĨA CÁC API ENDPOINTS
// =============================================

// POST /api/notifications - Tạo thông báo mới
router.post('/', NotificationController.createNotification);

// GET /api/notifications/:id - Lấy thông tin notification theo ID
router.get('/:id', NotificationController.getNotification);

// GET /api/notifications/history/:email - Lấy lịch sử notification của email
router.get('/history/:email', NotificationController.getNotificationHistory);

// POST /api/notifications/:id/resend - Gửi lại notification
router.post('/:id/resend', NotificationController.resendNotification);

// POST /api/notifications/process-pending - Xử lý pending notifications
router.post('/process-pending', NotificationController.processPendingNotifications);

// GET /api/notifications/stats - Lấy thống kê
router.get('/stats', NotificationController.getStats);

// Route test API
router.get('/test', (req, res) => {
    res.json({
        success: true,
        message: 'Notification Service đang hoạt động!',
        timestamp: new Date().toISOString()
    });
});

module.exports = router;