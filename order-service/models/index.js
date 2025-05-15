const { Sequelize, DataTypes } = require('sequelize');

// ⚠️ Nhớ cấu hình kết nối CSDL đúng với XAMPP của bạn
const sequelize = new Sequelize('order_service', 'root', '', {
  host: 'localhost',
  dialect: 'mysql'
});

// Khởi tạo model từ file
const Order = require('./Order')(sequelize, DataTypes);
const OrderItem = require('./OrderItem')(sequelize, DataTypes);

// Nếu cần liên kết
Order.hasMany(OrderItem, { foreignKey: 'order_id' });
OrderItem.belongsTo(Order, { foreignKey: 'order_id' });

// Export tất cả
module.exports = {
  sequelize,
  Sequelize,
  Order,
  OrderItem
};
