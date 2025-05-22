const { transporter } = require('../config/email');
const Notification = require('../models/Notification');

class EmailService {
    
    // Template email chào mừng khách hàng mới
    static getWelcomeTemplate(name) {
        return {
            subject: '🎉 Chào mừng bạn đến với Cửa hàng XYZ!',
            html: `
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;">
                        <h1 style="color: white; margin: 0;">Chào mừng ${name}!</h1>
                    </div>
                    <div style="padding: 30px; background: #f8f9fa;">
                        <p>Cảm ơn bạn đã đăng ký tài khoản tại Cửa hàng XYZ!</p>
                        <p>Bạn có thể bắt đầu mua sắm ngay bây giờ với hàng ngàn sản phẩm chất lượng.</p>
                        <div style="text-align: center; margin: 30px 0;">
                            <a href="#" style="background: #007bff; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px;">
                                Bắt đầu mua sắm
                            </a>
                        </div>
                        <p>Trân trọng,<br>Đội ngũ Cửa hàng XYZ</p>
                    </div>
                </div>
            `
        };
    }

    // Template xác nhận đơn hàng
    static getOrderConfirmTemplate(name, orderData) {
        const { orderId, totalAmount, items } = orderData;
        
        let itemsHtml = items.map(item => 
            `<tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">${item.name}</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: center;">${item.quantity}</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right;">${item.price.toLocaleString()}đ</td>
            </tr>`
        ).join('');

        return {
            subject: `✅ Xác nhận đơn hàng #${orderId}`,
            html: `
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <div style="background: #28a745; padding: 20px; text-align: center;">
                        <h1 style="color: white; margin: 0;">Đơn hàng đã được xác nhận!</h1>
                    </div>
                    <div style="padding: 30px;">
                        <p>Xin chào ${name},</p>
                        <p>Cảm ơn bạn đã đặt hàng! Đơn hàng #${orderId} của bạn đã được xác nhận.</p>
                        
                        <h3>Chi tiết đơn hàng:</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f8f9fa;">
                                    <th style="padding: 10px; text-align: left;">Sản phẩm</th>
                                    <th style="padding: 10px; text-align: center;">Số lượng</th>
                                    <th style="padding: 10px; text-align: right;">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${itemsHtml}
                            </tbody>
                            <tfoot>
                                <tr style="background: #f8f9fa; font-weight: bold;">
                                    <td colspan="2" style="padding: 15px;">Tổng cộng:</td>
                                    <td style="padding: 15px; text-align: right;">${totalAmount.toLocaleString()}đ</td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <p style="margin-top: 30px;">Đơn hàng sẽ được xử lý trong 1-2 ngày làm việc.</p>
                        <p>Trân trọng,<br>Đội ngũ Cửa hàng XYZ</p>
                    </div>
                </div>
            `
        };
    }

    
    // Hàm chính gửi email
    static async sendEmail(notification) {
        try {
            let emailContent;
            
            // Chọn template theo loại thông báo
            switch (notification.template_type) {
                case 'welcome':
                    emailContent = this.getWelcomeTemplate(notification.recipient_name);
                    break;
                    
                case 'order_confirm':
                    emailContent = this.getOrderConfirmTemplate(
                        notification.recipient_name, 
                        notification.metadata
                    );
                    break;
                    
                    
                default:
                    // Email thông thường không dùng template
                    emailContent = {
                        subject: notification.subject,
                        html: notification.message
                    };
            }

            // Cấu hình email sẽ gửi
            const mailOptions = {
                from: process.env.EMAIL_FROM,              // Người gửi
                to: notification.recipient_email,          // Người nhận
                subject: emailContent.subject,             // Tiêu đề
                html: emailContent.html                    // Nội dung HTML
            };

            // Gửi email thực tế
            const result = await transporter.sendMail(mailOptions);
            
            console.log(`✅ Gửi email thành công cho ${notification.recipient_email}`);
            
            // Cập nhật trạng thái thành công
            await Notification.updateStatus(notification.id, 'sent');
            
            return {
                success: true,
                messageId: result.messageId
            };
            
        } catch (error) {
            console.error(`❌ Lỗi gửi email cho ${notification.recipient_email}:`, error.message);
            
            // Tăng số lần thử gửi
            await Notification.incrementRetryCount(notification.id);
            
            // Nếu thử quá 3 lần thì đánh dấu failed
            const updatedNotification = await Notification.findById(notification.id);
            if (updatedNotification.retry_count >= 3) {
                await Notification.updateStatus(notification.id, 'failed', error.message);
            }
            
            return {
                success: false,
                error: error.message
            };
        }
    }

    // Xử lý hàng loạt notification đang chờ
    static async processPendingEmails() {
        try {
            const pendingNotifications = await Notification.getPendingNotifications();
            
            console.log(`📧 Tìm thấy ${pendingNotifications.length} email cần gửi`);
            
            // Gửi từng email một (có thể tối ưu bằng Promise.all)
            for (const notification of pendingNotifications) {
                await this.sendEmail(notification);
                
                // Nghỉ 1 giây giữa các email để tránh spam
                await new Promise(resolve => setTimeout(resolve, 1000));
            }
            
        } catch (error) {
            console.error('❌ Lỗi xử lý pending emails:', error.message);
        }
    }
}

module.exports = EmailService;