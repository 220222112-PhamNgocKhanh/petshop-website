const { Sequelize } = require('sequelize');

const sequelize = new Sequelize('order_service', 'root', '082004', {
    host: 'localhost',
    dialect: 'mysql', // hoặc 'postgres', tùy bạn dùng CSDL nào
    logging: false,
    timezone: '+07:00',
});

module.exports = sequelize;
