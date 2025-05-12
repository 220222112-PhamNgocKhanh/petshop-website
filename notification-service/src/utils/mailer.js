require('dotenv').config(); // 🚨 Đảm bảo biến môi trường được tải

const postmark = require("postmark");
const client = new postmark.ServerClient(process.env.POSTMARK_API_KEY); // 🔥 Sử dụng API Key từ .env

async function sendEmail(to, subject, body) {
    try {
        await client.sendEmail({
            From: process.env.EMAIL_USER, // 📌 Email phải được xác minh trong Postmark
            To: to,
            Subject: subject,
            TextBody: body
        });
        console.log("✅ Email sent via Postmark!");
    } catch (err) {
        console.error("❌ Error sending email via Postmark:", err.message);
    }
}

// 📌 Kiểm tra biến môi trường để đảm bảo API Key được tải đúng
console.log("📌 Postmark Config:", {
    apiKey: process.env.POSTMARK_API_KEY,
    sender: process.env.EMAIL_USER,
});

module.exports = { sendEmail };