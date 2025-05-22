const { pool } = require('../config/database');

class Notification {
    constructor(data) {
        this.recipient_email = data.recipient_email;   // Email người nhận
        this.recipient_name = data.recipient_name;     // Tên người nhận  
        this.subject = data.subject;                   // Tiêu đề email
        this.message = data.message;                   // Nội dung email
        this.template_type = data.template_type;       // Loại template (welcome, order_confirm, etc.)
        this.status = data.status || 'pending';        // Trạng thái: pending, sent, failed
        this.metadata = data.metadata || null;         // Dữ liệu bổ sung (JSON)
        this.retry_count = data.retry_count || 0;      // Số lần thử gửi lại
        this.scheduled_at = data.scheduled_at || null; // Thời gian hẹn gửi
    }

    // Lưu thông báo vào database
    async save() {
        const query = `
            INSERT INTO notifications 
            (recipient_email, recipient_name, subject, message, template_type, 
             status, metadata, retry_count, scheduled_at, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        `;
        
        try {
            const [result] = await pool.execute(query, [
                this.recipient_email,
                this.recipient_name,
                this.subject,
                this.message,
                this.template_type,
                this.status,
                JSON.stringify(this.metadata), // Chuyển object thành JSON string
                this.retry_count,
                this.scheduled_at
            ]);
            
            this.id = result.insertId; // Lấy ID vừa tạo
            return this;
        } catch (error) {
            throw new Error(`Lỗi lưu notification: ${error.message}`);
        }
    }

    // Tìm notification theo ID
    static async findById(id) {
        const query = 'SELECT * FROM notifications WHERE id = ?';
        
        try {
            const [rows] = await pool.execute(query, [id]);
            if (rows.length === 0) return null;
            
            const data = rows[0];
            // Chuyển JSON string thành object
            if (data.metadata) {
                data.metadata = JSON.parse(data.metadata);
            }
            return data;
        } catch (error) {
            throw new Error(`Lỗi tìm notification: ${error.message}`);
        }
    }

    // Lấy danh sách notification cần gửi (status = pending hoặc scheduled)
    static async getPendingNotifications() {
        const query = `
            SELECT * FROM notifications 
            WHERE (status = 'pending' OR 
                   (status = 'scheduled' AND scheduled_at <= NOW()))
            AND retry_count < 3
            ORDER BY created_at ASC
            LIMIT 100
        `;
        
        try {
            const [rows] = await pool.execute(query);
            return rows.map(row => {
                if (row.metadata) {
                    row.metadata = JSON.parse(row.metadata);
                }
                return row;
            });
        } catch (error) {
            throw new Error(`Lỗi lấy pending notifications: ${error.message}`);
        }
    }

    // Cập nhật trạng thái notification
    static async updateStatus(id, status, errorMessage = null) {
        const query = `
            UPDATE notifications 
            SET status = ?, error_message = ?, sent_at = ?, updated_at = NOW()
            WHERE id = ?
        `;
        
        const sentAt = status === 'sent' ? new Date() : null;
        
        try {
            await pool.execute(query, [status, errorMessage, sentAt, id]);
        } catch (error) {
            throw new Error(`Lỗi cập nhật status: ${error.message}`);
        }
    }

    // Tăng retry count khi gửi thất bại
    static async incrementRetryCount(id) {
        const query = `
            UPDATE notifications 
            SET retry_count = retry_count + 1, updated_at = NOW()
            WHERE id = ?
        `;
        
        try {
            await pool.execute(query, [id]);
        } catch (error) {
            throw new Error(`Lỗi tăng retry count: ${error.message}`);
        }
    }

    // Lấy lịch sử notification của một email
    static async getByEmail(email, limit = 50) {
        const query = `
            SELECT * FROM notifications 
            WHERE recipient_email = ? 
            ORDER BY created_at DESC 
            LIMIT ?
        `;
        
        try {
            const [rows] = await pool.execute(query, [email, limit]);
            return rows.map(row => {
                if (row.metadata) {
                    row.metadata = JSON.parse(row.metadata);
                }
                return row;
            });
        } catch (error) {
            throw new Error(`Lỗi lấy notification by email: ${error.message}`);
        }
    }
}

module.exports = Notification;