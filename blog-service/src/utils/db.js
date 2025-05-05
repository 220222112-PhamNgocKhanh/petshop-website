const { Sequelize } = require('sequelize');

const sequelize = new Sequelize('blog-service', 'root', '', {
    host: 'localhost',
    dialect: 'mysql',
    timezone: '+07:00',
    logging: false,
});

sequelize
    .authenticate()
    .then(() => console.log('Database connected successfully.'))
    .catch((err) => console.error('Unable to connect to the database:', err));

module.exports = sequelize;