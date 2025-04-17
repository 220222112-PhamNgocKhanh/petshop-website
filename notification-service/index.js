const http = require('http');
const router = require('./src/routes/notificationRouter');
require('dotenv').config();

const server = http.createServer((req, res) => {
  router(req, res);
});

const PORT = process.env.PORT || 3005;
server.listen(PORT, () => {
  console.log(`Notification service running on port ${PORT}`);
});
