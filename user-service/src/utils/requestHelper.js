const http = require('http');
require('dotenv').config();

function sendNotification(data) {
  const requestData = JSON.stringify(data);

  const options = {
    hostname: process.env.NOTIFICATION_HOST || 'localhost',
    port: process.env.NOTIFICATION_PORT || 3005,
    path: '/api/email/send',
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Content-Length': requestData.length
    }
  };

  const req = http.request(options, (res) => {
    res.on('data', (chunk) => {
      console.log(`📩 Notification Response: ${chunk}`);
    });
  });

  req.on('error', (error) => {
    console.error('❌ Error sending notification:', error.message);
  });

  req.write(requestData);
  req.end();
}

module.exports = { sendNotification };