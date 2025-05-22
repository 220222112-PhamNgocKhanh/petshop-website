const { sendEmail } = require('../utils/mailer');

module.exports = async function (req, res) {
    if (req.method === 'POST' && req.url === '/send-email') {
        let body = '';
        req.on('data', chunk => { body += chunk; });

        req.on('end', async () => {
            try {
                // 📌 Đọc dữ liệu từ request body
                const parsedBody = JSON.parse(body);
                const { to, eventType, data } = parsedBody; // 🔥 Đọc đúng eventType và data

                if (!eventType) {
                    console.error(`❌ Lỗi: eventType bị thiếu!`, { eventType });
                    return res.writeHead(400, { 'Content-Type': 'application/json' }).end(JSON.stringify({ success: false, message: 'Thiếu eventType!' }));
                }

                if (!data) {
                    console.error(`❌ Lỗi: data bị thiếu!`, { data });
                    return res.writeHead(400, { 'Content-Type': 'application/json' }).end(JSON.stringify({ success: false, message: 'Thiếu dữ liệu email!' }));
                }

                // 🚀 Gửi email đúng format
                await sendEmail(to, eventType, data);
                
                res.writeHead(200, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ success: true, message: 'Email sent!' }));
            } catch (error) {
                console.error(`❌ Lỗi khi gửi email:`, error.message);
                res.writeHead(500, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ success: false, error: error.message }));
            }
        });
    } else {
        res.writeHead(404);
        res.end('Not Found');
    }
};