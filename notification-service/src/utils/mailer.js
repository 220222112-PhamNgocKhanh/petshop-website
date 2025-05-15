require('dotenv').config();
const postmark = require("postmark");
const { accountCreated, passwordReset, orderConfirmation } = require("../utils/emailTemplates");

const client = new postmark.ServerClient(process.env.POSTMARK_API_KEY);

// 🚀 Hàm gửi email với kiểm tra riêng eventType và data
async function sendEmail(to, eventType, data) {
    try {
        // 🔥 Kiểm tra eventType
        if (!eventType) {
            console.error(`❌ Lỗi: eventType bị thiếu!`, { eventType });
            throw new Error("Thiếu eventType!");
        }

        // 🔥 Kiểm tra data
        if (!data) {
            console.error(`❌ Lỗi: data bị thiếu!`, { data });
            throw new Error("Thiếu data!");
        }

        // 📌 Xác định template dựa trên `eventType`
        let emailData;
        switch (eventType) {
            case 'accountCreated': emailData = accountCreated(data.username); break;
            case 'passwordReset': emailData = passwordReset(data.username, data.newPassword); break;
            case 'orderConfirmation': emailData = orderConfirmation(data.username, data.orderId); break;
            default:
                console.error(`❌ eventType không hợp lệ: ${eventType}`);
                throw new Error(`eventType không hợp lệ: ${eventType}`);
        }

        // 📌 Định dạng nội dung email
        const formattedBody = emailData.body.replace(/\n/g, '<br>');

        // 🚀 Gửi email
        await client.sendEmail({
            From: process.env.EMAIL_USER,
            To: to,
            Subject: emailData.subject,
            TextBody: emailData.body,
            HtmlBody: `<p>${formattedBody}</p>`
        });

        console.log(`✅ Email event '${eventType}' sent to ${to} via Postmark!`);
    } catch (err) {
        console.error(`❌ Error sending email event '${eventType}' to ${to}:`, err.message);
    }
}

// 🔥 Hiển thị cấu hình Postmark
console.log("📌 Postmark Config:", {
    apiKey: process.env.POSTMARK_API_KEY,
    sender: process.env.EMAIL_USER,
});

module.exports = { sendEmail };