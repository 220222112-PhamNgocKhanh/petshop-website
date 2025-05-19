const { DataTypes } = require('sequelize');
const sequelize = require('../utils/db');

const Blog = sequelize.define('Blog', {
    post_id: {
        type: DataTypes.INTEGER,
        autoIncrement: true,
        primaryKey: true,
    },
    title: {
        type: DataTypes.STRING(255),
        allowNull: false,
    },
    content: {
        type: DataTypes.TEXT,
        allowNull: false,
    },
    thumbnail: {
        type: DataTypes.STRING(255),
        allowNull: true,
        defaultValue: '/images/default-thumbnail.jpg'
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
    tableName: 'blogs',
    timestamps: false,
});

module.exports = Blog;