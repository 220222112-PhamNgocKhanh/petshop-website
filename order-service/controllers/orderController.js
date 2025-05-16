const axios = require('axios');
const dotenv = require('dotenv');
dotenv.config();

const {  Order, OrderItem } = require('../models');

//1. Tạo đơn hàng
exports.placeOrder = async (req, res) => {
    try {
        const { user_id, phone_number, shipping_address, items } = req.body;

        if (!user_id || !items || items.length === 0) {
            return res.status(400).json({ message: 'Thiếu thông tin cần thiết để tạo đơn hàng' });
        }

        // 1. Xác minh thông tin người dùng từ user-service
        try {
            const userResponse = await axios.get(`http://localhost:4000/user-service/user/${user_id}`, { family: 4 });
            if (userResponse.status !== 200) {
                return res.status(400).json({ message: 'Người dùng không hợp lệ' });
            }
        } catch (error) {
            console.error('Lỗi khi kết nối đến user-service:', error.message);
            return res.status(500).json({ message: 'Không thể kết nối đến user-service', error: error.message });
        }

        // 2. Xác minh thông tin sản phẩm từ product-service
        let total_price = 0;
        for (const item of items) {
            try {
                const productResponse = await axios.get(`http://localhost:6000/product-service/${item.product_id}`);
                if (productResponse.status !== 200) {
                    return res.status(400).json({ message: `Sản phẩm không hợp lệ: ${item.product_id}` });
                }

                const product = productResponse.data;
                if (product.quantity < item.amount) {
                    return res.status(400).json({ message: `Sản phẩm '${product.product_name}' không đủ hàng` });
                }

                total_price += item.amount * product.price;
            } catch (error) {
                console.error(`Lỗi khi kết nối đến product-service cho sản phẩm ${item.product_id}:`, error.message);
                return res.status(500).json({ message: `Không thể kết nối đến product-service cho sản phẩm ${item.product_id}`, error: error.message });
            }
        }

        // 3. Tạo đơn hàng trong cơ sở dữ liệu
        const order = await Order.create({
            user_id,
            status: 'pending',
            total_price,
            phone_number,
            shipping_address
        });

        // 4. Tạo các mục đơn hàng
        for (const item of items) {
            await OrderItem.create({
                order_id: order.order_id,
                product_id: item.product_id,
                quantity: item.amount,
                price: item.price
            });

            // Gửi yêu cầu cập nhật tồn kho sản phẩm đến product-service
            try {
                await axios.put(`http://localhost:6000/product-service/${item.product_id}/decrement`, {
                    amount: item.amount
                });
            } catch (error) {
                console.error(`Lỗi khi cập nhật tồn kho sản phẩm ${item.product_id}:`, error.message);
                return res.status(500).json({ message: `Không thể cập nhật tồn kho sản phẩm ${item.product_id}`, error: error.message });
            }
        }

        res.status(201).json({
            message: 'Đặt hàng thành công',
            order_id: order.order_id
        });

    } catch (err) {
        console.error('Lỗi khi tạo đơn hàng:', err);
        res.status(500).json({
            message: 'Lỗi khi tạo đơn hàng',
            error: err.message
        });
    }
};



// 2. Lấy danh sách đơn hàng theo user
exports.getOrdersByUser = async (req, res) => {
    try {
        const { user_id } = req.params;  // Lấy user_id từ params (không phải query string)

        if (!user_id) {
            return res.status(400).json({ message: 'Thiếu user_id trong đường dẫn' });
        }

        // Truy vấn đơn hàng của user theo user_id
        const orders = await Order.findAll({
            where: { user_id }
        });

        if (!orders || orders.length === 0) {
            return res.status(404).json({ message: 'Không tìm thấy đơn hàng cho user_id này' });
        }

        // Lấy các items của từng đơn hàng
        const ordersWithItems = [];
        for (let order of orders) {
            const items = await OrderItem.findAll({ where: { order_id: order.order_id } });
            ordersWithItems.push({ order, items });
          }

        // Trả về đơn hàng và các items của chúng
        res.json(ordersWithItems);
    } catch (err) {
        console.error('Lỗi khi truy vấn đơn hàng:', err);
        res.status(500).json({ message: 'Lỗi truy vấn đơn hàng', error: err.message });
    }
};

// 3. Lấy chi tiết đơn hàng
exports.getOrderDetail = async (req, res) => {
    try {
        const { id } = req.params;
        const order = await Order.findByPk(id);
        if (!order) return res.status(404).json({ message: 'Không tìm thấy đơn hàng' });

        const items = await OrderItem.findAll({ where: { order_id: id } });
        res.json({ order, items });
    } catch (err) {
        res.status(500).json({ message: 'Lỗi truy vấn chi tiết đơn hàng' });
    }
};

// 4. Cập nhật trạng thái đơn hàng (Admin)
exports.updateOrderStatus = async (req, res) => {
    try {
        const { id, newStatus } = req.params; // Get the newStatus from the URL params
        console.log(`Updating order status: id=${id}, newStatus=${newStatus}`); // Log the input values

        const result = await Order.update(
            { status: newStatus, updated_at: new Date() }, // Cập nhật cả updated_at
            { where: { order_id: id } }
        );
        console.log(`Update result:`, result); // Log the result of the update query

        if (result[0] === 0) {
            return res.status(404).json({ message: 'Không tìm thấy đơn hàng' });
        }

        res.json({ message: 'Cập nhật trạng thái thành công' });
    } catch (err) {
        console.error('Error updating order status:', err); // Log the error
        res.status(500).json({ message: 'Lỗi cập nhật trạng thái', error: err.message });
    }
};

// 5. Hủy đơn hàng
exports.cancelOrder = async (req, res) => {
    try {
        const { id } = req.params;

        const result = await Order.update({ status: 'cancelled' }, { where: { order_id: id } });

        if (result[0] === 0) {
            return res.status(404).json({ message: 'Không tìm thấy đơn hàng' });
        }

        // (Gửi thông báo nếu cần)
        res.json({ message: 'Đã hủy đơn hàng' });
    } catch (err) {
        res.status(500).json({ message: 'Lỗi hủy đơn hàng' });
    }
};

// 6. Lấy tất cả đơn hàng
exports.getAllOrders = async (req, res) => {
    try {
      // Lấy tất cả đơn hàng
      const orders = await Order.findAll();
  
      if (!orders.length) {
        return res.status(404).json({ message: 'Không có đơn hàng nào' });
      }
  
      // Lấy thêm item cho từng đơn hàng
      const ordersWithItems = [];
      for (const order of orders) {
        const items = await OrderItem.findAll({ where: { order_id: order.order_id } });
        ordersWithItems.push({ order, items });
      }
  
      res.json(ordersWithItems);
    } catch (err) {
      console.error('Lỗi khi truy vấn tất cả đơn hàng:', err);
      res.status(500).json({ message: 'Lỗi truy vấn tất cả đơn hàng', error: err.message });
    }
  };

// 7. Lấy danh sách đơn hàng theo trạng thái
exports.getOrdersByStatus = async (req, res) => {
    try {
        const { status } = req.params; // <-- thay vì req.query
 // Lấy trạng thái từ query string

        // Kiểm tra nếu không có trạng thái được cung cấp
        if (!status) {
            return res.status(400).json({ message: 'Thiếu trạng thái đơn hàng' });
        }

        // Lấy danh sách đơn hàng theo trạng thái
        const orders = await Order.findAll({ where: { status } });

        if (!orders || orders.length === 0) {
            return res.status(404).json({ message: 'Không tìm thấy đơn hàng với trạng thái này' });
        }

        // Trả về danh sách đơn hàng
        res.json(orders);
    } catch (err) {
        console.error('Lỗi khi lấy danh sách đơn hàng theo trạng thái:', err);
        res.status(500).json({ message: 'Lỗi khi lấy danh sách đơn hàng', error: err.message });
    }
};


