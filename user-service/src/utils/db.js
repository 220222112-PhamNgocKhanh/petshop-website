const { Sequelize } = require('sequelize');

// Cung cấp thông tin kết nối trực tiếp
const sequelize = new Sequelize('user_service', 'root', '', {
    host: 'localhost',
    port: 3306,
    dialect: 'mysql',
});

sequelize
    .authenticate()
    .then(() => console.log('Database connected...'))
    .catch((err) => console.error('Unable to connect to the database:', err));

module.exports = sequelize;