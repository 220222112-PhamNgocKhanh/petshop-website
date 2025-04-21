<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="sidebar.css">
    <style>
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .order-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .order-filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-group select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 150px;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .order-table th, .order-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .order-table tr:hover {
            background-color: #f5f5f5;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background: #ffeeba;
            color: #856404;
        }

        .status-processing {
            background: #b8daff;
            color: #004085;
        }

        .status-completed {
            background: #c3e6cb;
            color: #155724;
        }

        .status-cancelled {
            background: #f5c6cb;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .view-btn, .update-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .view-btn {
            background: #17a2b8;
        }

        .view-btn:hover {
            background: #138496;
        }

        .update-btn {
            background: #28a745;
        }

        .update-btn:hover {
            background: #218838;
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
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close-btn {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }

        .order-details {
            margin-top: 20px;
        }

        .order-info, .customer-info, .products-list {
            margin-bottom: 20px;
        }

        .section-title {
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
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
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="content">
        <div class="order-container">
            <div class="order-header">
                <h1>Quản lý Đơn hàng</h1>
            </div>

            <div class="order-filters">
                <div class="filter-group">
                    <label>Trạng thái:</label>
                    <select id="statusFilter">
                        <option value="">Tất cả</option>
                        <option value="pending">Chờ xử lý</option>
                        <option value="processing">Đang xử lý</option>
                        <option value="completed">Hoàn thành</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Sắp xếp:</label>
                    <select id="sortFilter">
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                    </select>
                </div>
            </div>

            <div id="message"></div>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    <!-- Dữ liệu đơn hàng sẽ được thêm vào đây -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal chi tiết đơn hàng -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Chi tiết đơn hàng #<span id="orderNumber"></span></h2>
            
            <div class="order-details">
                <div class="order-info">
                    <h3 class="section-title">Thông tin đơn hàng</h3>
                    <p>Ngày đặt: <span id="orderDate"></span></p>
                    <p>Trạng thái: <span id="orderStatus"></span></p>
                    <p>Tổng tiền: <span id="orderTotal"></span></p>
                </div>

                <div class="customer-info">
                    <h3 class="section-title">Thông tin khách hàng</h3>
                    <p>Tên: <span id="customerName"></span></p>
                    <p>Email: <span id="customerEmail"></span></p>
                    <p>Địa chỉ: <span id="customerAddress"></span></p>
                    <p>Số điện thoại: <span id="customerPhone"></span></p>
                </div>

                <div class="products-list">
                    <h3 class="section-title">Danh sách sản phẩm</h3>
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="productsList">
                            <!-- Danh sách sản phẩm sẽ được thêm vào đây -->
                        </tbody>
                    </table>
                </div>

                <div class="order-actions">
                    <select id="updateStatus">
                        <option value="pending">Chờ xử lý</option>
                        <option value="processing">Đang xử lý</option>
                        <option value="completed">Hoàn thành</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                    <button onclick="updateOrderStatus()" class="update-btn">Cập nhật trạng thái</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadOrders();

            // Thêm event listeners cho các bộ lọc
            document.getElementById('statusFilter').addEventListener('change', loadOrders);
            document.getElementById('sortFilter').addEventListener('change', loadOrders);
        });

        async function loadOrders() {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    showMessage('Vui lòng đăng nhập lại', true);
                    setTimeout(() => {
                        window.location.href = '../login.php';
                    }, 2000);
                    return;
                }

                const status = document.getElementById('statusFilter').value;
                const sort = document.getElementById('sortFilter').value;

                const response = await fetch(`http://localhost:3000/order-service/orders?status=${status}&sort=${sort}`, {
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

                const orders = await response.json();
                displayOrders(orders);
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tải danh sách đơn hàng', true);
            }
        }

        function displayOrders(orders) {
            const tableBody = document.getElementById('orderTable');
            tableBody.innerHTML = '';

            orders.forEach(order => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>#${order.order_id}</td>
                    <td>${order.customer_name}</td>
                    <td>${new Date(order.created_at).toLocaleDateString('vi-VN')}</td>
                    <td>${formatCurrency(order.total_amount)}</td>
                    <td><span class="status-badge status-${order.status.toLowerCase()}">${getStatusText(order.status)}</span></td>
                    <td class="action-buttons">
                        <button class="view-btn" onclick="viewOrder(${order.order_id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="update-btn" onclick="showUpdateStatus(${order.order_id})">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function getStatusText(status) {
            const statusMap = {
                'pending': 'Chờ xử lý',
                'processing': 'Đang xử lý',
                'completed': 'Hoàn thành',
                'cancelled': 'Đã hủy'
            };
            return statusMap[status.toLowerCase()] || status;
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }

        async function viewOrder(orderId) {
            try {
                const token = localStorage.getItem('token');
                const response = await fetch(`http://localhost:3000/order-service/orders/${orderId}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                const order = await response.json();
                if (response.ok) {
                    displayOrderDetails(order);
                    document.getElementById('orderModal').style.display = 'block';
                } else {
                    showMessage(order.message || 'Lỗi khi tải thông tin đơn hàng', true);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tải thông tin đơn hàng', true);
            }
        }

        function displayOrderDetails(order) {
            document.getElementById('orderNumber').textContent = order.order_id;
            document.getElementById('orderDate').textContent = new Date(order.created_at).toLocaleDateString('vi-VN');
            document.getElementById('orderStatus').textContent = getStatusText(order.status);
            document.getElementById('orderTotal').textContent = formatCurrency(order.total_amount);
            
            document.getElementById('customerName').textContent = order.customer_name;
            document.getElementById('customerEmail').textContent = order.customer_email;
            document.getElementById('customerAddress').textContent = order.shipping_address;
            document.getElementById('customerPhone').textContent = order.phone_number;

            const productsList = document.getElementById('productsList');
            productsList.innerHTML = '';
            
            order.products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.name}</td>
                    <td>${product.quantity}</td>
                    <td>${formatCurrency(product.price)}</td>
                    <td>${formatCurrency(product.price * product.quantity)}</td>
                `;
                productsList.appendChild(row);
            });

            document.getElementById('updateStatus').value = order.status.toLowerCase();
        }

        async function updateOrderStatus() {
            const orderId = document.getElementById('orderNumber').textContent;
            const newStatus = document.getElementById('updateStatus').value;

            try {
                const token = localStorage.getItem('token');
                const response = await fetch(`http://localhost:3000/order-service/orders/${orderId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const result = await response.json();
                if (response.ok) {
                    showMessage('Cập nhật trạng thái thành công');
                    loadOrders();
                    closeModal();
                } else {
                    showMessage(result.message || 'Lỗi khi cập nhật trạng thái', true);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi cập nhật trạng thái', true);
            }
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
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
            if (event.target == document.getElementById('orderModal')) {
                closeModal();
            }
        }

        // Close modal when clicking the close button
        document.querySelector('.close-btn').onclick = closeModal;
    </script>
</body>
</html>
