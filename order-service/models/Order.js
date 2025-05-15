module.exports = (sequelize, DataTypes) => {
    const Order = sequelize.define('Order', {
        order_id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true,
        },
        user_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        status: {
            type: DataTypes.ENUM('pending', 'confirmed', 'shipping', 'delivered', 'cancelled'),
            defaultValue: 'pending',
        },
        total_price: {
            type: DataTypes.FLOAT,
            allowNull: false,
        },
        phone_number: {
            type: DataTypes.STRING(20),
            allowNull: false,
        },
        shipping_address: {
            type: DataTypes.STRING(255),
            allowNull: false,
        },
        created_at: {
            type: DataTypes.DATE,
            defaultValue: DataTypes.NOW,
        },
        updated_at: {
            type: DataTypes.DATE,
            defaultValue: DataTypes.NOW,
            onUpdate: DataTypes.NOW, // Sequelize tự động cập nhật khi có thay đổi
        }
    }, {
        tableName: 'orders',
        timestamps: false,  // Bạn có thể tắt timestamps nếu không cần trường created_at và updated_at tự động.
    });

    // Tự động tạo bảng nếu chưa tồn tại
    Order.sync();

    // Optional: Thiết lập mối quan hệ nếu cần
    // Order.hasMany(OrderItem, { foreignKey: 'order_id' });
    // OrderItem.belongsTo(Order, { foreignKey: 'order_id' });

    return Order;
};
