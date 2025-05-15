require('dotenv').config();
const http = require('http');
const router = require('./src/routes/notificationRouter');

const PORT = process.env.PORT || 3005;

console.log('📌 ENV Config:', {
    PORT: process.env.PORT,
    POSTMARK_API_KEY: process.env.POSTMARK_API_KEY,
    EMAIL_USER: process.env.EMAIL_USER
});

if (!process.env.POSTMARK_API_KEY) {
    console.error('❌ Lỗi: POSTMARK_API_KEY chưa được cấu hình!');
    process.exit(1);
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
    process.exit(1);
}