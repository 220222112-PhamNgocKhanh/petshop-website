const cron = require('node-cron');
const EmailService = require('../services/EmailService');

class EmailProcessor {
    
    // Khởi động các cron jobs
    static start() {
        console.log('🚀 Khởi động Email Processor...');
        
        // Chạy mỗi phút để xử lý pending emails
        cron.schedule('* * * * *', async () => {
            console.log('⏰ Chạy job xử lý pending emails...');
            try {
                await EmailService.processPendingEmails();
            } catch (error) {
                console.error('❌ Lỗi trong cron job:', error);
            }
        });
        
        // Chạy mỗi giờ để cleanup old notifications (xóa dữ liệu cũ)
        cron.schedule('0 * * * *', async () => {
            console.log('🧹 Chạy job cleanup dữ liệu cũ...');
            try {
                await this.cleanupOldNotifications();
            } catch (error) {
                console.error('❌ Lỗi cleanup:', error);
            }
        });
        
        console.log('✅ Email Processor đã khởi động!');
    }
    
    // Xóa notification cũ hơn 30 ngày
    static async cleanupOldNotifications() {
        const { pool } = require('../config/database');
        
        try {
            const query = `
                DELETE FROM notifications 
                WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
                AND status IN ('sent', 'failed')
            `;
            
            const [result] = await pool.execute(query);
            console.log(`🗑️ Đã xóa ${result.affectedRows} notification cũ`);
            
        } catch (error) {
            console.error('❌ Lỗi cleanup old notifications:', error);
        }
    }
}

module.exports = EmailProcessor;