const Notification = require('../models/Notification');
const EmailService = require('../services/EmailService');
const Joi = require('joi'); // Thư viện validate dữ liệu

class NotificationController {
    
    // Schema validate dữ liệu đầu vào
    static createNotificationSchema = Joi.object({
        recipient_email: Joi.string().email().required()
            .messages({
                'string.email': 'Email không hợp lệ',
                'any.required': 'Email là bắt buộc'
            }),
        recipient_name: Joi.string().min(1).max(100).required()
            .messages({
                'any.required': 'Tên người nhận là bắt buộc'
            }),
        subject: Joi.string().min(1).max(255).when('template_type', {
            is: Joi.exist(),
            then: Joi.optional(), // Nếu có template thì subject tùy chọn
            otherwise: Joi.required() // Không có template thì subject bắt buộc
        }),
        message: Joi.string().when('template_type', {
            is: Joi.exist(),
            then: Joi.optional(),
            otherwise: Joi.required()
        }),
        template_type: Joi.string().valid('welcome', 'order_confirm', 'promotion').optional(),
        metadata: Joi.object().optional(),
        scheduled_at: Joi.date().greater('now').optional()
            .messages({
                'date.greater': 'Thời gian hẹn gửi phải lớn hơn hiện tại'
            })
    });

    // API tạo thông báo mới
    // POST /api/notifications
    static async createNotification(req, res) {
        try {
            // Validate dữ liệu đầu vào
            const { error, value } = NotificationController.createNotificationSchema.validate(req.body);
            if (error) {
                return res.status(400).json({
                    success: false,
                    message: 'Dữ liệu không hợp lệ',
                    errors: error.details.map(detail => detail.message)
                });
            }

            // Tạo notification mới
            const notification = new Notification(value);
            await notification.save();

            console.log(`📝 Tạo notification mới: ID ${notification.id}`);

            // Nếu không phải scheduled thì gửi luôn
            if (!notification.scheduled_at) {
                // Gửi email ngay (async, không chờ)
                EmailService.sendEmail(notification)
                    .then(result => {
                        if (result.success) {
                            console.log(`✅ Email ID ${notification.id} đã gửi thành công`);
                        }
                    })
                    .catch(error => {
                        console.error(`❌ Lỗi gửi email ID ${notification.id}:`, error);
                    });
            }

            res.status(201).json({
                success: true,
                message: 'Tạo thông báo thành công',
                data: {
                    id: notification.id,
                    status: notification.status,
                    scheduled_at: notification.scheduled_at
                }
            });

        } catch (error) {
            console.error('❌ Lỗi tạo notification:', error);
            res.status(500).json({
                success: false,
                message: 'Lỗi server nội bộ',
                error: error.message
            });
        }
    }

    // API lấy thông tin notification theo ID
    // GET /api/notifications/:id
    static async getNotification(req, res) {
        try {
            const { id } = req.params;

            // Validate ID
            if (!id || isNaN(id)) {
                return res.status(400).json({
                    success: false,
                    message: 'ID không hợp lệ'
                });
            }

            const notification = await Notification.findById(id);
            
            if (!notification) {
                return res.status(404).json({
                    success: false,
                    message: 'Không tìm thấy thông báo'
                });
            }

            res.json({
                success: true,
                data: notification
            });

        } catch (error) {
            console.error('❌ Lỗi lấy notification:', error);
            res.status(500).json({
                success: false,
                message: 'Lỗi server nội bộ',
                error: error.message
            });
        }
    }

    // API lấy lịch sử thông báo của một email
    // GET /api/notifications/history/:email
    static async getNotificationHistory(req, res) {
        try {
            const { email } = req.params;
            const limit = parseInt(req.query.limit) || 50;

            // Validate email
            const emailSchema = Joi.string().email().required();
            const { error } = emailSchema.validate(email);
            if (error) {
                return res.status(400).json({
                    success: false,
                    message: 'Email không hợp lệ'
                });
            }

            const notifications = await Notification.getByEmail(email, limit);

            res.json({
                success: true,
                data: notifications,
                total: notifications.length
            });

        } catch (error) {
            console.error('❌ Lỗi lấy lịch sử notification:', error);
            res.status(500).json({
                success: false,
                message: 'Lỗi server nội bộ',
                error: error.message
            });
        }
    }

    // API gửi lại email thất bại
    // POST /api/notifications/:id/resend
    static async resendNotification(req, res) {
        try {
            const { id } = req.params;

            const notification = await Notification.findById(id);
            if (!notification) {
                return res.status(404).json({
                    success: false,
                    message: 'Không tìm thấy thông báo'
                });
            }

            // Chỉ cho phép gửi lại những email failed hoặc pending
            if (!['failed', 'pending'].includes(notification.status)) {
                return res.status(400).json({
                    success: false,
                    message: 'Chỉ có thể gửi lại email có trạng thái failed hoặc pending'
                });
            }

            // Reset lại retry count và status
            await Notification.updateStatus(id, 'pending');
            notification.status = 'pending';
            notification.retry_count = 0;

            // Gửi email
            const result = await EmailService.sendEmail(notification);

            if (result.success) {
                res.json({
                    success: true,
                    message: 'Gửi lại email thành công'
                });
            } else {
                res.status(500).json({
                    success: false,
                    message: 'Gửi lại email thất bại',
                    error: result.error
                });
            }

        } catch (error) {
            console.error('❌ Lỗi gửi lại notification:', error);
            res.status(500).json({
                success: false,
                message: 'Lỗi server nội bộ',
                error: error.message
            });
        }
    }

    // API xử lý hàng loạt email đang chờ (dùng cho cron job)
    // POST /api/notifications/process-pending
    static async processPendingNotifications(req, res) {
        try {
            await EmailService.processPendingEmails();
            
            res.json({
                success: true,
                message: 'Đã xử lý xong pending notifications'
            });

        } catch (error) {
            console.error('❌ Lỗi xử lý pending notifications:', error);
            res.status(500).json({
                success: false,
                message: 'Lỗi server nội bộ',
                error: error.message
            });
        }
    }

    // API thống kê
    // GET /api/notifications/stats
    static async getStats(req, res) {
        try {
            const { pool } = require('../config/database');
            
            const query = `
                SELECT 
                    status,
                    COUNT(*) as count,
                    DATE(created_at) as date
                FROM notifications 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                GROUP BY status, DATE(created_at)
                ORDER BY date DESC
            `;
            
            const [rows] = await pool.execute(query);
            
            res.json({
                success: true,
                data: rows
            });

        } catch (error) {
            console.error('❌ Lỗi lấy thống kê:', error);
            res.status(500).json({
                success: false,
                message: 'Lỗi server nội bộ',
                error: error.message
            });
        }
    }
}

module.exports = NotificationController;