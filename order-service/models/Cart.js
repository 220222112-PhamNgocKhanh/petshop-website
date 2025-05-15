module.exports = (sequelize, DataTypes) => {
    const Cart = sequelize.define('Cart', {
        product_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,
        },
        user_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,
        },
        amount: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        total_price: {
            type: DataTypes.FLOAT,
            allowNull: false,
        },
    }, {
        tableName: 'carts',
        timestamps: false,
        // Không tạo tự động cột id
        createdAt: false,
        updatedAt: false,
        freezeTableName: true,
        // Bỏ mặc định cột id
        noPrimaryKey: false,
    });

    // Tự động tạo bảng nếu chưa tồn tại
    Cart.sync();

    return Cart;
};
