const { DataTypes } = require('sequelize');
const sequelize = require('../utils/db');

const User = sequelize.define('User', {
    user_id: {
        type: DataTypes.INTEGER,
        autoIncrement: true,
        primaryKey: true,
    },
    username: {
        type: DataTypes.STRING(50),
        allowNull: false,
        unique: 'unique_username', 
    },
    password_hash: {
        type: DataTypes.STRING(255),
        allowNull: false,
    },
    email: {
        type: DataTypes.STRING(100),
        allowNull: false,
        unique: 'unique_email', 
    },
    address: {
        type: DataTypes.STRING(255),
        allowNull: true,
    },
    role: {
        type: DataTypes.STRING(25),
        defaultValue: 'user',
    },
    created_at: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
        timezone: '+07:00',
    },
    updated_at: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
        onUpdate: DataTypes.NOW,
        timezone: '+07:00',
    }
}, {
    tableName: 'users',
    timestamps: false,
});

module.exports = User;
