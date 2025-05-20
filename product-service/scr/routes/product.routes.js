const express = require('express');
const router = express.Router();
const productController = require('../controllers/product.controller');

// 📊 Thống kê & đặc biệt
router.get('/count', productController.countTotalProducts);  // Thêm route đếm tổng số sản phẩm
router.get('/count-by-category', productController.countByCategory);  // GET thay vì POST vì chỉ lấy dữ liệu
router.get('/latest', productController.latestProduct);

// 🔍 Tìm kiếm
router.get('/searchbyname/:name', productController.getProductByName);
router.get('/search/:categoryName', productController.getProductBycategory);
router.get('/search-category/:categoryName/:keyword', productController.searchInCategory);

// Upload routes - phải đặt TRƯỚC các route có parameter :id
router.post('/upload', productController.processUpload, productController.uploadProductImage);
router.put('/upload/:id', productController.processUpload, productController.updateProductWithImage);

// 🧩 CRUD cơ bản
router.post('/', productController.createProduct);
router.get('/', productController.getProducts);
router.get('/:id', productController.getProductById);
router.put('/:id', productController.updateProduct);
router.delete('/:id', productController.deleteProduct);
router.put('/:id/decrease-quantity', productController.decreaseProductQuantity);
module.exports = router;
