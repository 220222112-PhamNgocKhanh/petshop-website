const http = require('http');
const { createProxyMiddleware } = require('http-proxy-middleware');
const express = require('express');

const app = express();

// Định nghĩa các dịch vụ mà API Gateway sẽ chuyển tiếp yêu cầu đến
const services = {
  'user-service': 'http://localhost:3001',  // User Service chạy trên cổng 3001
  // Các dịch vụ khác có thể thêm ở đây (Product, Order, v.v.)
};

// Route mặc định để trả về thông điệp khi người dùng truy cập vào /
app.get('/', (req, res) => {
  res.send('Welcome to the API Gateway! Use /user for user service.');
});

// Cấu hình proxy để chuyển tiếp yêu cầu từ frontend đến User Service
app.use('/user', createProxyMiddleware({
  target: services['user-service'],
  changeOrigin: true,
  pathRewrite: { '^/user': '' },
}));

// Lắng nghe các yêu cầu đến API Gateway
app.listen(3000, () => {
  console.log('API Gateway is running on http://localhost:3000');
});
