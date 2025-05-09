const { DataTypes } = require('sequelize');
const sequelize = require('../db');

const CartItem = sequelize.define('CartItem', {
  userId: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  productId: {
    type: DataTypes.INTEGER,
    allowNull: false,
  },
  quantity: {
    type: DataTypes.INTEGER,
    allowNull: false,
    defaultValue: 1,
  },
}, {
  tableName: 'cart_items',
  timestamps: true,
  updatedAt: 'updated_at',
  createdAt: false,
  indexes: [
    {
      unique: true,
      fields: ['userId', 'productId'],
    },
  ],
});

module.exports = CartItem;
