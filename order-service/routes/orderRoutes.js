const express = require('express');
const orderController = require('../controllers/orderController'); // Thư mục chứa logic của các chức năng order
const router = express.Router();

// 1. Đặt hàng (Place Order)
router.post('/place', orderController.placeOrder);

// 2. Lấy tất cả đơn hàng
router.get('/all', orderController.getAllOrders);

// 3. Lấy danh sách đơn hàng theo user_id (GET /orders?user_id=...)
router.get('/user/:user_id', orderController.getOrdersByUser);

// 4. Xem chi tiết đơn hàng (GET /orders/:id)
router.get('/:id', orderController.getOrderDetail);

// 5. Cập nhật trạng thái đơn hàng (PUT /orders/:id/status/:newStatus)
router.put('/:id/status/:newStatus', orderController.updateOrderStatus);

// 6. Hủy đơn hàng (PUT /orders/:id với status "cancelled")
router.put('/:id/cancel', orderController.cancelOrder);

// 7. Lấy danh sách đơn hàng theo trạng thái
router.get('/status/:status', orderController.getOrdersByStatus);

module.exports = router;
