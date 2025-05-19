const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
require('dotenv').config(); // Add dotenv
const sequelize = require('./utils/db'); // Sequelize connection
const orderRoutes = require('./routes/orderRoutes'); // Các route xử lý yêu cầu
const Order = require('./models/Order'); // Import models để sync
const OrderItem = require('./models/OrderItem');

const app = express();
const PORT = process.env.PORT || 4003; // Use environment variable with fallback

app.use(cors());

app.use((req, res, next) => {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    if (req.method === 'OPTIONS') {
        res.status(204).end();
        return;
    }

    next();
});

// Middleware
app.use(bodyParser.json());

// Routes
app.use('/order-service', orderRoutes);

// Kết nối DB và chạy server
sequelize.sync({ force: false }) // Sử dụng { force: true } nếu muốn reset bảng, alter nhẹ hơn
    .then(() => {
        console.log('✅ Kết nối database thành công!');
        app.listen(PORT, () => {
            console.log(`🚀 Order Service đang chạy tại http://localhost:${PORT}`);
        });
    })
    .catch(err => {
        console.error('❌ Lỗi khi kết nối database:', err);
    });
