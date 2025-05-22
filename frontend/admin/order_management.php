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
            /* margin-left: 260px; */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .order-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-section {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .search-main {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .filter-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-group label {
            font-weight: 500;
            color: #333;
            white-space: nowrap;
        }

        .filter-group select {
            padding: 8px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            min-width: 180px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .filter-group select:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 0 2px rgba(23, 162, 184, 0.1);
            outline: none;
            background-color: #ffffff;
        }

        .search-input {
            padding: 12px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            width: 300px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .search-input:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 0 2px rgba(23, 162, 184, 0.1);
            outline: none;
            background-color: #ffffff;
        }

        .search-btn {
            padding: 12px 25px;
            background: #17a2b8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-btn:hover {
            background: #138496;
        }

        .order-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .order-table th {
            background-color: #f8f9fa;
            padding: 15px;
            font-weight: 600;
            color: #333;
            text-align: left;
        }

        .order-table td {
            padding: 15px;
            color: #4a4a4a;
        }

        .order-table tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            text-align: center;
            min-width: 100px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }

        .status-processing {
            background: #cce5ff;
            color: #004085;
            border-color: #b8daff;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .status-confirmed {
            background: #e3f2fd;
            color: #0d47a1;
            border-color: #bbdefb;
        }

        .status-shipping {
            background: #fff8e1;
            color: #ff6f00;
            border-color: #ffecb3;
        }

        .status-delivered {
            background: #e8f5e9;
            color: #1b5e20;
            border-color: #c8e6c9;
        }

        .status-cancelled {
            background: #ffebee;
            color: #b71c1c;
            border-color: #ffcdd2;
        }

        .payment-status-pending {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }

        .payment-status-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .payment-status-cancelled {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .status-actions {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .status-actions button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .confirm-btn {
            background: #28a745;
        }

        .confirm-btn:hover {
            background: #218838;
        }

        .update-btn {
            background: #17a2b8;
        }

        .update-btn:hover {
            background: #138496;
        }

        .confirm-payment-btn {
            background: #28a745;
        }

        .confirm-payment-btn:hover {
            background: #218838;
        }

        .edit-payment-btn {
            background: #17a2b8;
        }

        .edit-payment-btn:hover {
            background: #138496;
        }

        .shipping-btn {
            background: #ff9800;
        }

        .shipping-btn:hover {
            background: #f57c00;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
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

        .order-info,
        .customer-info,
        .products-list {
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

        .order-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .order-actions select {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            background-color: #f8f9fa;
            min-width: 180px;
            transition: all 0.3s ease;
        }

        .order-actions select:focus {
            outline: none;
            background-color: #ffffff;
            box-shadow: 0 0 0 2px rgba(23, 162, 184, 0.1);
        }

        .order-actions button {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            background: #17a2b8;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .order-actions button:hover {
            background: #138496;
        }

        .payment-status-form {
            padding: 20px;
        }

        .payment-status-form select {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            background-color: #f8f9fa;
            min-width: 180px;
            transition: all 0.3s ease;
        }

        .payment-status-form select:focus {
            outline: none;
            background-color: #ffffff;
            box-shadow: 0 0 0 2px rgba(23, 162, 184, 0.1);
        }

        .payment-status-form button {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            background: #17a2b8;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .payment-status-form button:hover {
            background: #138496;
        }

        .products-list {
            margin-bottom: 20px;
        }

        .total-price {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #eee;
            text-align: right;
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .total-price span {
            color: #17a2b8;
            margin-left: 10px;
        }

        .delivered-btn {
            background: #28a745;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .delivered-btn:hover {
            background: #218838;
        }

        .cancel-btn {
            background: #dc3545;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .cancel-btn:hover {
            background: #c82333;
        }

        .cancel-btn:disabled {
            background: #dc3545;
            opacity: 0.65;
            cursor: not-allowed;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 10px;
        }

        .pagination button {
            padding: 8px 15px;
            border: 1px solid #ddd;
            background-color: white;
            color: #333;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .pagination button:hover:not(:disabled) {
            background-color: #f0f0f0;
            border-color: #999;
        }

        .pagination button:disabled {
            background-color: #f5f5f5;
            color: #999;
            cursor: not-allowed;
        }

        .pagination span {
            padding: 8px 15px;
            color: #666;
        }

        .order-container {
            margin-bottom: 20px;
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

            <div class="search-section">
                <div class="search-main">
                    <input type="text" id="userNameSearch" class="search-input" placeholder="Nhập tên người dùng để tìm kiếm">
                    <button onclick="searchOrdersByUserName()" class="search-btn">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>
                </div>
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Trạng thái đơn hàng:</label>
                        <select id="statusFilter">
                            <option value="">Tất cả</option>
                            <option value="pending">Chờ xử lý</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="shipping">Đang vận chuyển</option>
                            <option value="delivered">Đã giao</option>
                            <option value="cancelled">Đã huỷ</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Trạng thái thanh toán:</label>
                        <select id="paymentStatusFilter">
                            <option value="">Tất cả</option>
                            <option value="pending">Chờ thanh toán</option>
                            <option value="success">Thanh toán thành công</option>
                            <option value="cancelled">Đã hủy thanh toán</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="message"></div>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày cập nhật</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái đơn hàng</th>
                        <th>Trạng thái thanh toán</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
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
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="productsList">
                            <!-- Danh sách sản phẩm sẽ được thêm vào đây -->
                        </tbody>
                    </table>
                </div>

                <div class="order-actions">
                    <button onclick="updateOrderStatus(${order.order_id}, 'delivered')" class="delivered-btn" id="deliveredBtn">
                        <i class="fas fa-check-circle"></i> Đã nhận
                    </button>
                    <button onclick="updateOrderStatus(${order.order_id}, 'cancelled')" class="cancel-btn" id="cancelBtn">
                        <i class="fas fa-times-circle"></i> Hủy đơn
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        const ordersPerPage = 20;
        let allOrders = [];

        async function fetchAllOrders() {
            try {
                const response = await fetch('http://localhost:3000/order-service/all');

                if (!response.ok) {
                    throw new Error('Không thể tải danh sách đơn hàng');
                }

                allOrders = await response.json();
                renderOrders(allOrders);
            } catch (error) {
                console.error('Lỗi khi tải danh sách đơn hàng:', error);
                alert('Không thể tải danh sách đơn hàng. Vui lòng thử lại sau.');
            }
        }
        async function fetchUserById(userId) {
            try {
                const response = await fetch(`http://localhost:3000/user-service/user/${userId}`);

                if (!response.ok) {
                    throw new Error('Không thể tải thông tin người dùng');
                }
                return await response.json();
            } catch (error) {
                console.error('Lỗi khi tải thông tin người dùng:', error);
                return null;
            }
        }

        async function renderOrders(orders) {
            // Sort orders by updated_at descending (newest first)
            orders.sort((a, b) => {
                const aOrder = a.order || a;
                const bOrder = b.order || b;
                return new Date(bOrder.updated_at) - new Date(aOrder.updated_at);
            });

            // Tính toán phân trang
            const startIndex = (currentPage - 1) * ordersPerPage;
            const endIndex = startIndex + ordersPerPage;
            const paginatedOrders = orders.slice(startIndex, endIndex);

            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';

            const userCache = {};

            for (const item of paginatedOrders) {
                const order = item.order || item;

                if (!order.user_id) {
                    console.warn('Thiếu user_id trong đơn hàng:', order);
                    continue;
                }

                let user;
                if (userCache[order.user_id]) {
                    user = userCache[order.user_id];
                } else {
                    user = await fetchUserById(order.user_id);
                    userCache[order.user_id] = user;
                }

                // Lấy thông tin thanh toán từ payment service
                let paymentInfo;
                try {
                    const paymentResponse = await fetch(`http://localhost:3000/payment-service/payments/${order.order_id}`, {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (paymentResponse.ok) {
                        paymentInfo = await paymentResponse.json();
                    }
                } catch (error) {
                    console.error('Lỗi khi lấy thông tin thanh toán:', error);
                }

                const userName = user?.username || 'Không rõ';
                const paymentStatus = paymentInfo?.status || 'pending';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${order.order_id}</td>
                    <td>${userName}</td>
                    <td>${new Date(order.updated_at).toLocaleDateString()}</td>
                    <td>${Number(order.total_price + 5 || 0).toLocaleString()} $</td>
                    <td>
                        <span class="status-badge status-${order.status}">${getStatusText(order.status)}</span>
                        <div class="status-actions">
                            ${order.status === 'pending' ? `
                            <button class="confirm-btn" onclick="confirmOrder(${order.order_id})" title="Xác nhận đơn hàng">
                                <i class="fas fa-check-circle"></i> Xác nhận
                            </button>` : ''}
                            ${order.status === 'confirmed' ? `
                            <button class="shipping-btn" onclick="updateOrderStatus(${order.order_id}, 'shipping')" title="Chuyển sang vận chuyển">
                                <i class="fas fa-truck"></i> Vận chuyển
                            </button>` : ''}
                            <button class="update-btn" onclick="showUpdateStatus(${order.order_id})" title="Chỉnh sửa trạng thái">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </button>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge payment-status-${paymentStatus}">${getPaymentStatusText(paymentStatus)}</span>
                        <div>Phương thức: ${paymentInfo?.payment_method || 'Tiền mặt (COD)'}</div>
                    </td>
                `;
                tableBody.appendChild(row);
            }

            // Tạo phân trang
            createPagination(orders.length);
        }

        function getStatusText(status) {
            if (!status) return 'Không xác định';
            const statusMap = {
                pending: "Chờ xử lý",
                confirmed: "Đã xác nhận",
                shipping: "Đang vận chuyển",
                delivered: "Đã giao hàng",
                cancelled: "Đã hủy"
            };
            return statusMap[status.toLowerCase()] || status;
        }

        function getPaymentStatusText(status) {
            const statusMap = {
                pending: "Chờ thanh toán",
                success: "Thanh toán thành công",
                cancelled: "Đã hủy thanh toán"
            };
            return statusMap[status] || status;
        }

        async function confirmOrder(orderId) {
            try {
                const response = await fetch(`http://localhost:3000/order-service/${orderId}/status/confirmed`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Không thể xác nhận đơn hàng');
                }

                const result = await response.json();
                showMessage(result.message || 'Đơn hàng đã được xác nhận');

                // Lấy chi tiết đơn hàng để trừ số lượng sản phẩm
                const orderDetailRes = await fetch(`http://localhost:3000/order-service/${orderId}`);
                if (orderDetailRes.ok) {
                    const orderDetail = await orderDetailRes.json();
                    if (orderDetail.items && Array.isArray(orderDetail.items)) {
                        for (const item of orderDetail.items) {
                            // Gọi API trừ số lượng sản phẩm
                            await fetch(`http://localhost:3000/product-service/products/${item.product_id}/decrease-quantity`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    quantity: item.quantity
                                })
                            });
                        }
                    }
                }

                fetchAllOrders(); // Tải lại danh sách đơn hàng sau khi xác nhận thành công
            } catch (error) {
                console.error('Lỗi khi xác nhận đơn hàng:', error);
                showMessage('Không thể xác nhận đơn hàng. Vui lòng thử lại sau.', true);
            }
        }

        async function viewOrderDetails(orderId) {
            try {
                const response = await fetch(`http://localhost:3000/order-service/${orderId}`);

                if (!response.ok) {
                    console.error(`Failed to fetch order details. Status: ${response.status}`);
                    throw new Error(`Không thể tải chi tiết đơn hàng. Mã lỗi: ${response.status}`);
                }

                const order = await response.json();
                console.log('Order details fetched successfully:', order);

                displayOrderDetails(order);
                document.getElementById('orderModal').style.display = 'block';
            } catch (error) {
                console.error('Lỗi khi tải chi tiết đơn hàng:', error);
                alert('Không thể tải chi tiết đơn hàng. Vui lòng thử lại sau.');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Lấy tham số status từ URL
            const urlParams = new URLSearchParams(window.location.search);
            const statusParam = urlParams.get('status');
            
            // Nếu có tham số status, set giá trị cho bộ lọc và lọc đơn hàng
            if (statusParam) {
                const statusFilter = document.getElementById('statusFilter');
                statusFilter.value = statusParam;
                // Kích hoạt sự kiện change để lọc đơn hàng
                statusFilter.dispatchEvent(new Event('change'));
            } else {
                fetchAllOrders();
            }
        });

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        }

        async function getUserById(userId) {
            const response = await fetch(`http://localhost:3000/user-service/user/${userId}`);
            const user = await response.json();
            return user;
        }

        async function getProductInfo(productId) {
            try {
                const response = await fetch(`http://localhost:3000/product-service/products/${productId}`);
                if (!response.ok) {
                    throw new Error('Không thể lấy thông tin sản phẩm');
                }
                return await response.json();
            } catch (error) {
                console.error('Lỗi khi lấy thông tin sản phẩm:', error);
                return null;
            }
        }
       
        async function displayOrderDetails(order) {
            const user = await getUserById(order.order.user_id);

            document.getElementById('orderNumber').textContent = order.order.order_id;
            document.getElementById('orderDate').textContent = new Date(order.order.created_at).toLocaleDateString('vi-VN');
            document.getElementById('orderStatus').textContent = getStatusText(order.order.status);

            // Hiển thị thông tin khách hàng nếu có
            document.getElementById('customerName').textContent = user.username || 'Không xác định';
            document.getElementById('customerEmail').textContent = user.email || 'Không xác định';
            document.getElementById('customerAddress').textContent = order.order.shipping_address || 'Không xác định';
            document.getElementById('customerPhone').textContent = order.order.phone_number || 'Không xác định';

            // Hiển thị danh sách sản phẩm
            const productsList = document.getElementById('productsList');
            productsList.innerHTML = '';

            if (order.items && Array.isArray(order.items)) {
                for (let i = 0; i < order.items.length; i++) {
                    const product = await getProductInfo(order.items[i].product_id);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${product.product.name || 'Không xác định'}</td>
                        <td>${order.items[i].quantity || 0}</td>
                        <td>${formatCurrency(product?.product?.price || 0)}</td>
                        <td>${formatCurrency((product?.product?.price || 0) * (order.items[i].quantity || 0))}</td>
                    `;
                    productsList.appendChild(row);
                }
                // Thêm dòng hiển thị phí ship
                const shippingRow = document.createElement('tr');
                shippingRow.innerHTML = `
                    <td colspan="3" style="text-align: right;">Phí vận chuyển:</td>
                    <td>${formatCurrency(5)}</td>
                `;
                productsList.appendChild(shippingRow);

                // Thêm tổng tiền ở cuối bảng
                const totalRow = document.createElement('tr');
                totalRow.className = 'total-price';
                totalRow.innerHTML = `
                    <td colspan="3" style="text-align: right;"><h1>Tổng tiền:</h1></td>
                    <td><span>${formatCurrency(order.order.total_price + 5)}</span></td>
                `;
                productsList.appendChild(totalRow);
            } else {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="4">Không có sản phẩm</td>';
                productsList.appendChild(row);
            }

            // Xử lý hiển thị nút dựa trên trạng thái đơn hàng
            const orderActions = document.querySelector('.order-actions');
            orderActions.innerHTML = `
                <button onclick="updateOrderStatus(${order.order.order_id}, 'delivered')" class="delivered-btn" id="deliveredBtn">
                    <i class="fas fa-check-circle"></i> Đã nhận
                </button>
                <button onclick="updateOrderStatus(${order.order.order_id}, 'cancelled')" class="cancel-btn" id="cancelBtn">
                    <i class="fas fa-times-circle"></i> Hủy đơn
                </button>
            `;

            const deliveredBtn = document.getElementById('deliveredBtn');
            const cancelBtn = document.getElementById('cancelBtn');

            if (order.order.status === 'cancelled') {
                deliveredBtn.style.display = 'none';
                cancelBtn.disabled = true;
            } else {
                deliveredBtn.style.display = 'flex';
                cancelBtn.disabled = false;
            }
        }

        async function updateOrderStatus(orderId, directStatus = null) {
            try {
                const newStatus = directStatus || document.getElementById('updateStatus').value;

                // 1. Lấy thông tin đơn hàng hiện tại
                const orderDetailRes = await fetch(`http://localhost:3000/order-service/${orderId}`);
                if (!orderDetailRes.ok) {
                    throw new Error('Không thể lấy chi tiết đơn hàng');
                }
                const orderDetail = await orderDetailRes.json();
                const oldStatus = orderDetail.order.status;

                if (directStatus === 'shipping' && oldStatus !== 'confirmed') {
                    throw new Error('Chỉ có thể chuyển sang vận chuyển khi đơn hàng đã được xác nhận');
                }

                // 2. Cập nhật trạng thái
                const response = await fetch(`http://localhost:3000/order-service/${orderId}/status/${newStatus}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Không thể cập nhật trạng thái đơn hàng');
                }

                // 3. Cập nhật trạng thái thanh toán
                const paymentResult = await getPaymentInfo(orderId);
                if (paymentResult.success && paymentResult.data) {
                    const paymentId = paymentResult.data.id;
                    let newPaymentStatus = paymentResult.data.status;

                    if ((oldStatus === 'confirmed' && (newStatus === 'shipping' || newStatus === 'delivered')) ||
                        (oldStatus === 'pending' && (newStatus === 'shipping' || newStatus === 'delivered'))) {
                        newPaymentStatus = 'success';
                    } else if ((oldStatus === 'shipping' || oldStatus === 'delivered') && newStatus === 'cancelled') {
                        newPaymentStatus = 'cancelled';
                    }

                    if (newPaymentStatus !== paymentResult.data.status) {
                        const paymentResponse = await fetch(`http://localhost:3000/payment-service/payments/${paymentId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                status: newPaymentStatus
                            })
                        });

                        if (!paymentResponse.ok) {
                            console.error('Không thể cập nhật trạng thái thanh toán');
                        }
                    }
                }

                // 4. Xử lý số lượng sản phẩm nếu hủy đơn
                if (newStatus === 'cancelled' && oldStatus !== 'pending') {
                    if (orderDetail.items && Array.isArray(orderDetail.items)) {
                        for (const item of orderDetail.items) {
                            const productRes = await fetch(`http://localhost:3000/product-service/products/${item.product_id}`);
                            if (!productRes.ok) continue;
                            const productData = await productRes.json();
                            const currentAmount = productData.product.amount || 0;
                            const newAmount = currentAmount + item.quantity;

                            await fetch(`http://localhost:3000/product-service/products/${item.product_id}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    amount: newAmount
                                })
                            });
                        }
                    }
                }

                const result = await response.json();
                showMessage(result.message || 'Cập nhật trạng thái thành công');
                closeModal(); // Đóng modal sau khi cập nhật thành công
                fetchAllOrders();
            } catch (error) {
                console.error('Lỗi khi cập nhật trạng thái đơn hàng:', error);
                showMessage(error.message || 'Không thể cập nhật trạng thái đơn hàng. Vui lòng thử lại sau.', true);
            }
        }

        function showUpdateStatus(orderId) {
            // Gọi hàm viewOrderDetails để tải thông tin chi tiết đơn hàng
            viewOrderDetails(orderId);
        }

        function closeModal() {
            const modal = document.getElementById('orderModal');
            if (modal) {
                modal.style.display = 'none';
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
            if (event.target == document.getElementById('orderModal')) {
                closeModal();
            }
        }

        // Close modal when clicking the close button
        document.querySelector('.close-btn').onclick = closeModal;

        document.getElementById('statusFilter').addEventListener('change', async function() {
            const status = this.value; // Lấy giá trị trạng thái được chọn

            if (status === '') { // Nếu chọn "Tất cả"
                fetchAllOrders(); // Gọi hàm fetchAllOrders để lấy tất cả đơn hàng
            } else {
                try {
                    const response = await fetch(`http://localhost:3000/order-service/status/${status}`); // Truy vấn theo trạng thái

                    if (!response.ok) {
                        throw new Error('Không thể tải danh sách đơn hàng theo trạng thái');
                    }

                    const orders = await response.json();
                    renderOrders(orders); // Hiển thị danh sách đơn hàng được lọc
                } catch (error) {
                    console.error('Lỗi khi lọc đơn hàng theo trạng thái:', error);
                    alert('Không thể tải danh sách đơn hàng. Vui lòng thử lại sau.');
                }
            }
        });

        async function searchOrdersByUserName() {
            const userName = document.getElementById('userNameSearch').value.trim().toLowerCase();

            try {
                const response = await fetch('http://localhost:3000/order-service/all');
                if (!response.ok) {
                    throw new Error('Không thể tải danh sách đơn hàng');
                }

                const orders = await response.json();
                const userCache = {};
                const filteredOrders = [];

                for (const item of orders) {
                    const order = item.order || item;
                    if (!order.user_id) continue;

                    let user;
                    if (userCache[order.user_id]) {
                        user = userCache[order.user_id];
                    } else {
                        const userResponse = await fetch(`http://localhost:3000/user-service/user/${order.user_id}`);
                        if (userResponse.ok) {
                            user = await userResponse.json();
                            userCache[order.user_id] = user;
                        }
                    }

                    if (user && (user.username.toLowerCase().includes(userName) || 
                                user.email.toLowerCase().includes(userName))) {
                        filteredOrders.push(item);
                    }
                }

                if (filteredOrders.length === 0) {
                    showMessage('Không tìm thấy đơn hàng phù hợp', true);
                    return;
                }

                allOrders = filteredOrders;
                currentPage = 1; // Reset về trang đầu tiên khi tìm kiếm
                renderOrders(allOrders);
                showMessage(`Tìm thấy ${filteredOrders.length} đơn hàng phù hợp`, false);

            } catch (error) {
                console.error('Lỗi khi tìm kiếm đơn hàng:', error);
                showMessage('Không thể tìm kiếm đơn hàng. Vui lòng thử lại sau.', true);
            }
        }

        async function getPaymentInfo(orderId) {
            try {
                const response = await fetch(`http://localhost:3000/payment-service/payments/${orderId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const payment = await response.json();
                return {
                    success: true,
                    data: payment
                };
            } catch (error) {
                console.error('Lỗi khi lấy thông tin thanh toán:', error);
                return {
                    success: false,
                    error: error.message || 'Không thể lấy thông tin thanh toán'
                };
            }
        }

        async function confirmPayment(orderId) {
            try {
                // Lấy thông tin payment trước
                const paymentResult = await getPaymentInfo(orderId);
                if (!paymentResult.success || !paymentResult.data) {
                    throw new Error('Không tìm thấy thông tin thanh toán');
                }

                const paymentId = paymentResult.data.id;
                
                const response = await fetch(`http://localhost:3000/payment-service/payments/${paymentId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'success'
                    })
                });

                if (!response.ok) {
                    throw new Error('Không thể xác nhận thanh toán');
                }

                const result = await response.json();
                showMessage(result.message || 'Đã xác nhận thanh toán thành công');
                fetchAllOrders();
            } catch (error) {
                console.error('Lỗi khi xác nhận thanh toán:', error);
                showMessage('Không thể xác nhận thanh toán. Vui lòng thử lại sau.', true);
            }
        }

        function showUpdatePaymentStatus(orderId) {
            const modal = document.createElement('div');
            modal.className = 'modal';
            modal.id = 'paymentStatusModal';
            modal.innerHTML = `
                <div class="modal-content">
                    <span class="close-btn">&times;</span>
                    <h2>Chỉnh sửa thông tin thanh toán</h2>
                    <div class="payment-status-form">
                        <p>Mã đơn hàng: <strong>${orderId}</strong></p>
                        <div class="form-group">
                            <label>Trạng thái thanh toán:</label>
                            <select id="updatePaymentStatus">
                                <option value="pending">Chờ thanh toán</option>
                                <option value="success">Thanh toán thành công</option>
                                <option value="cancelled">Đã hủy thanh toán</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Phương thức thanh toán:</label>
                            <select id="updatePaymentMethod">
                                <option value="cash">Tiền mặt (COD)</option>
                            </select>
                        </div>
                        <button onclick="updatePaymentStatus(${orderId})" class="update-btn">Cập nhật</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.style.display = 'block';

            // Thêm sự kiện đóng modal
            const closeBtn = modal.querySelector('.close-btn');
            closeBtn.onclick = function() {
                modal.remove();
            };

            // Đóng modal khi click bên ngoài
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.remove();
                }
            };
        }

        async function updatePaymentStatus(orderId) {
            try {
                const paymentResult = await getPaymentInfo(orderId);
                if (!paymentResult.success || !paymentResult.data) {
                    throw new Error('Không tìm thấy thông tin thanh toán');
                }

                const paymentId = paymentResult.data.id;
                const newStatus = document.getElementById('updatePaymentStatus').value;
                
                const response = await fetch(`http://localhost:3000/payment-service/payments/${paymentId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                if (!response.ok) {
                    throw new Error('Không thể cập nhật thông tin thanh toán');
                }

                const result = await response.json();
                showMessage(result.message || 'Cập nhật thông tin thanh toán thành công');
                fetchAllOrders();
                
                // Đóng modal payment status
                const modal = document.getElementById('paymentStatusModal');
                if (modal) {
                    modal.remove();
                }
            } catch (error) {
                console.error('Lỗi khi cập nhật thông tin thanh toán:', error);
                showMessage('Không thể cập nhật thông tin thanh toán. Vui lòng thử lại sau.', true);
            }
        }

        // Thêm event listener cho bộ lọc trạng thái thanh toán
        document.getElementById('paymentStatusFilter').addEventListener('change', async function() {
            const paymentStatus = this.value;

            if (paymentStatus === '') {
                fetchAllOrders();
            } else {
                try {
                    const response = await fetch(`http://localhost:3000/order-service/payment-status/${paymentStatus}`);

                    if (!response.ok) {
                        throw new Error('Không thể lọc đơn hàng theo trạng thái thanh toán');
                    }

                    const orders = await response.json();
                    renderOrders(orders);
                } catch (error) {
                    console.error('Lỗi khi lọc đơn hàng theo trạng thái thanh toán:', error);
                    alert('Không thể lọc đơn hàng. Vui lòng thử lại sau.');
                }
            }
        });

        // Thêm hàm lấy tổng số thanh toán thành công
        async function getTotalSuccessfulPayments() {
            try {
                const response = await fetch('http://localhost:3000/payment-service/payments/total-successful', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Không thể lấy tổng số thanh toán thành công');
                }

                const result = await response.json();
                return result;
            } catch (error) {
                console.error('Lỗi khi lấy tổng số thanh toán thành công:', error);
                return null;
            }
        }

        function createPagination(totalOrders) {
            const totalPages = Math.ceil(totalOrders / ordersPerPage);
            console.log('Debug pagination:', {
                totalOrders,
                ordersPerPage,
                totalPages,
                currentPage
            });
            
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination';
            paginationContainer.innerHTML = `
                <button onclick="changePage(1)" ${currentPage <= 1 ? 'disabled' : ''}>Đầu</button>
                <button onclick="changePage(${currentPage - 1})" ${currentPage <= 1 ? 'disabled' : ''}>Trước</button>
                <span>Trang ${currentPage} / ${totalPages}</span>
                <button onclick="changePage(${currentPage + 1})" ${currentPage >= totalPages ? 'disabled' : ''}>Sau</button>
                <button onclick="changePage(${totalPages})" ${currentPage >= totalPages ? 'disabled' : ''}>Cuối</button>
            `;

            // Xóa phân trang cũ nếu có
            const oldPagination = document.querySelector('.pagination');
            if (oldPagination) {
                oldPagination.remove();
            }

            // Thêm phân trang mới
            document.querySelector('.order-container').appendChild(paginationContainer);
        }

        function changePage(newPage) {
            const totalPages = Math.ceil(allOrders.length / ordersPerPage);
            if (newPage < 1) newPage = 1;
            if (newPage > totalPages) newPage = totalPages;
            
            currentPage = newPage;
            renderOrders(allOrders);
        }
    </script>
</body>

</html>