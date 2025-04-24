<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="sidebar.css">
    <style>
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .product-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-product-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .add-product-btn:hover {
            background: #218838;
        }

        .search-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 300px;
        }

        .search-container button {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-container button:hover {
            background: #0056b3;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .product-table th, .product-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .product-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .product-table tr:hover {
            background-color: #f5f5f5;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .edit-btn {
            background: #007bff;
        }

        .edit-btn:hover {
            background: #0056b3;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .preview-image {
            max-width: 200px;
            margin-top: 10px;
        }

        #message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            display: none;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .stock-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .in-stock {
            background: #c3e6cb;
            color: #155724;
        }

        .low-stock {
            background: #ffeeba;
            color: #856404;
        }

        .out-of-stock {
            background: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="content">
        <div class="product-container">
            <div class="product-header">
                <h1>Quản lý Sản phẩm</h1>
                <button class="add-product-btn" onclick="openModal()">
                    <i class="fas fa-plus"></i>
                    Thêm sản phẩm
                </button>
            </div>

            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Tìm kiếm sản phẩm...">
                <button onclick="searchProducts()">
                    <i class="fas fa-search"></i>
                    Tìm kiếm
                </button>
            </div>

            <div id="message"></div>

            <table class="product-table">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    <!-- Dữ liệu sản phẩm sẽ được thêm vào đây -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal thêm/sửa sản phẩm -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Thêm sản phẩm mới</h2>
            <form id="productForm">
                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="number" id="price" name="price" min="0" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Số lượng</label>
                    <input type="number" id="quantity" name="quantity" min="0" required>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Danh mục</label>
                    <select id="category" name="category" required>
                        <option value="">Chọn danh mục</option>
                        <option value="food">Thức ăn</option>
                        <option value="toys">Đồ chơi</option>
                        <option value="accessories">Phụ kiện</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Hình ảnh</label>
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                    <img id="imagePreview" class="preview-image" style="display: none;">
                </div>
                <button type="submit" class="add-product-btn">Lưu sản phẩm</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
        });

        async function loadProducts() {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    showMessage('Vui lòng đăng nhập lại', true);
                    setTimeout(() => {
                        window.location.href = '../login.php';
                    }, 2000);
                    return;
                }

                const response = await fetch('http://localhost:3000/product-service/products', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.status === 403) {
                    showMessage('Bạn không có quyền truy cập trang này', true);
                    setTimeout(() => {
                        window.location.href = '../login.php';
                    }, 2000);
                    return;
                }

                const products = await response.json();
                
                displayProducts(products.products);
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tải danh sách sản phẩm', true);
            }
        }

        function displayProducts(products) {
            const tableBody = document.getElementById('productTable');
            tableBody.innerHTML = '';

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><img src="../../backend/image/${product.category}/${product.image || '../images/default-product.jpg'}" alt="${product.name}" class="product-image"></td>
                    <td>${product.name}</td>
                    <td>${formatCurrency(product.price)}</td>
                    <td>${product.amount}</td>
                    <td><span class="stock-status ${getStockStatusClass(product.quantity)}">${getStockStatusText(product.quantity)}</span></td>
                    <td class="action-buttons">
                        <button class="edit-btn" onclick="editProduct(${product.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-btn" onclick="deleteProduct(${product.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function getStockStatusClass(quantity) {
            if (quantity > 10) return 'in-stock';
            if (quantity > 0) return 'low-stock';
            return 'out-of-stock';
        }

        function getStockStatusText(quantity) {
            if (quantity > 10) return 'Còn hàng';
            if (quantity > 0) return 'Sắp hết';
            return 'Hết hàng';
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        function openModal(productId = null) {
            document.getElementById('productModal').style.display = 'block';
            document.getElementById('modalTitle').textContent = productId ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới';
            document.getElementById('productForm').reset();
            document.getElementById('imagePreview').style.display = 'none';
        }

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        async function searchProducts() {
            const searchTerm = document.getElementById('searchInput').value;
            try {
                const token = localStorage.getItem('token');
                const response = await fetch(`http://localhost:3000/product-service/products/search?q=${searchTerm}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                const products = await response.json();
                if (response.ok) {
                    displayProducts(products);
                } else {
                    showMessage('Không tìm thấy sản phẩm', true);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tìm kiếm sản phẩm', true);
            }
        }

        document.getElementById('productForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            try {
                const token = localStorage.getItem('token');
                const response = await fetch('http://localhost:3000/product-service/products', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });

                const result = await response.json();
                if (response.ok) {
                    showMessage('Thêm sản phẩm thành công');
                    closeModal();
                    loadProducts();
                } else {
                    showMessage(result.message || 'Lỗi khi thêm sản phẩm', true);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi thêm sản phẩm', true);
            }
        });

        async function editProduct(productId) {
            try {
                const token = localStorage.getItem('token');
                const response = await fetch(`http://localhost:3000/product-service/products/${productId}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                const product = await response.json();
                if (response.ok) {
                    openModal(productId);
                    // Fill form with product data
                    document.getElementById('name').value = product.name;
                    document.getElementById('price').value = product.price;
                    document.getElementById('quantity').value = product.quantity;
                    document.getElementById('description').value = product.description;
                    document.getElementById('category').value = product.category;
                    if (product.image_url) {
                        document.getElementById('imagePreview').src = product.image_url;
                        document.getElementById('imagePreview').style.display = 'block';
                    }
                } else {
                    showMessage(product.message || 'Lỗi khi tải thông tin sản phẩm', true);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tải thông tin sản phẩm', true);
            }
        }

        async function deleteProduct(productId) {
            if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                return;
            }

            try {
                const token = localStorage.getItem('token');
                const response = await fetch(`http://localhost:3000/product-service/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                const result = await response.json();
                if (response.ok) {
                    showMessage('Xóa sản phẩm thành công');
                    loadProducts();
                } else {
                    showMessage(result.message || 'Lỗi khi xóa sản phẩm', true);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi xóa sản phẩm', true);
            }
        }

        function showMessage(message, isError = false) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = message;
            messageDiv.className = isError ? 'error' : 'success';
            messageDiv.style.display = 'block';
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 3000);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('productModal')) {
                closeModal();
            }
        }

        // Add event listener for Enter key in search input
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchProducts();
            }
        });
    </script>
</body>
</html>
