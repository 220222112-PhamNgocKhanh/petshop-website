require('dotenv').config(); // 🚨 Load biến môi trường trước mọi lệnh khác!
const http = require('http');
const router = require('./src/routes/notificationRouter');

const PORT = process.env.PORT || 3005;

// 📌 Kiểm tra biến môi trường để đảm bảo `POSTMARK_API_KEY` đã được tải
console.log('📌 ENV Config:', {
    PORT: process.env.PORT,
    POSTMARK_API_KEY: process.env.POSTMARK_API_KEY,
    EMAIL_USER: process.env.EMAIL_USER
});

// 🚨 Kiểm tra API Key trước khi khởi động server
if (!process.env.POSTMARK_API_KEY) {
    console.error('❌ Lỗi: POSTMARK_API_KEY chưa được cấu hình trong .env!');
    process.exit(1); // 🚨 Dừng chương trình nếu thiếu API Key
}

try {
    const server = http.createServer((req, res) => {
        router(req, res);
    });

    server.listen(PORT, () => {
        console.log(`✅ Notification service running on port ${PORT}`);
    });
} catch (error) {
    console.error(`❌ Lỗi khởi động server: ${error.message}`);
    process.exit(1); // 🚨 Dừng chương trình nếu có lỗi nghiêm trọng
}