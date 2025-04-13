const { Sequelize } = require('sequelize');

// Kết nối đến cơ sở dữ liệu MySQL
const sequelize = new Sequelize('payment_service', 'root', '', {
    host: 'localhost',
    dialect: 'mysql',
    timezone: '+07:00', // Thiết lập múi giờ cho Việt Nam
    logging: false, // Tắt log SQL (bạn có thể bật nếu cần)
});

// Kiểm tra kết nối
sequelize
    .authenticate()
    .then(() => console.log('Database connected successfully.'))
    .catch((err) => console.error('Unable to connect to the database:', err));

module.exports = sequelize;