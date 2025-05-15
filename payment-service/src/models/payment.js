const { DataTypes } = require('sequelize');
const sequelize = require('../utils/db');

const Payment = sequelize.define('Payment', {
    id: {
        type: DataTypes.INTEGER,
        autoIncrement: true,
        primaryKey: true,
    },
    order_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
    },
    user_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
    },
    amount: {
        type: DataTypes.DECIMAL(12, 2),
        allowNull: false,
    },
    currency: {
        type: DataTypes.STRING(10),
        defaultValue: 'USD',
    },
    status: {
        type: DataTypes.ENUM('pending', 'success', 'cancelled'),
        defaultValue: 'pending',
    },
    payment_method: {
        type: DataTypes.STRING(50),
        defaultValue: 'cash',
    },
    transaction_id: {
        type: DataTypes.STRING(100),
        unique: true,
    },
    created_at: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
    },
    updated_at: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
        onUpdate: DataTypes.NOW,
    },
}, {
    tableName: 'payments',
    timestamps: false, // Không sử dụng timestamps tự động của Sequelize
});

module.exports = Payment;