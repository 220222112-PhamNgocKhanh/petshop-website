// models/Product.js

module.exports = (sequelize, DataTypes) => {
    const Product = sequelize.define('Product', {
        product_id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true
        },
        product_name: {
            type: DataTypes.STRING,
            allowNull: false
        },
        description: {
            type: DataTypes.TEXT
        },
        price: {
            type: DataTypes.FLOAT,
            allowNull: false
        },
        quantity: {
            type: DataTypes.INTEGER,
            allowNull: false
        },
        category_id: {
            type: DataTypes.INTEGER,
            allowNull: false
        },
        image_url: {
            type: DataTypes.STRING
        },
        created_at: {
            type: DataTypes.DATE,
            defaultValue: DataTypes.NOW
        },
        updated_at: {
            type: DataTypes.DATE,
            defaultValue: DataTypes.NOW
        }
    }, {
        tableName: 'products',
        timestamps: false // hoặc true nếu bạn dùng Sequelize để tự cập nhật
    });

    // Tự động tạo bảng nếu chưa tồn tại
    Product.sync();

    return Product;
};
