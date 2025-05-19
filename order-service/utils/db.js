const { Sequelize } = require('sequelize');
require('dotenv').config();

console.log('DEBUG => DB_PASSWORD:', process.env.DB_PASSWORD);


const sequelize = new Sequelize(
    process.env.DB_NAME || 'order_service', 
    process.env.DB_USER || 'root', 
    process.env.DB_PASSWORD || '082004', 
    {
        host: process.env.DB_HOST || 'localhost',
        dialect: process.env.DB_DIALECT || 'mysql',
        logging: false
    }
);

module.exports = sequelize;
