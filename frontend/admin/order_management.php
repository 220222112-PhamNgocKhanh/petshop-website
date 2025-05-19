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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .order-table th,
        .order-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #000;
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

        .payment-status-pending {
            background: #ffeeba;
            color: #856404;
        }

        .payment-status-paid {
            background: #c3e6cb;
            color: #155724;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .view-btn,
        .update-btn {
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
            background: #17a2b8;
        }

        .update-btn:hover {
            background: #138496;
        }

        .confirm-btn {
            background: #28a745;
        }

        .confirm-btn:hover {
            background: #218838;
        }

        .confirm-payment-btn {
            background: #28a745;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .confirm-payment-btn:hover {
            background: #218838;
        }

        .edit-payment-btn {
            background: #17a2b8;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .edit-payment-btn:hover {
            background: #138496;
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

        .status-actions {
            display: flex;
            gap: 5px;
            margin-top: 5px;
        }

        .status-actions button {
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            font-size: 12px;
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
                        <option value="paid">Đã thanh toán</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Sắp xếp:</label>
                    <select id="sortFilter">
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Tìm kiếm theo Tên User:</label>
                    <input type="text" id="userNameSearch" placeholder="Nhập Tên User">
                    <button onclick="searchOrdersByUserName()">Tìm kiếm</button>
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
                        <th>Hành động</th>
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
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="shipping">Shipping</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <button onclick="updateOrderStatus()" class="update-btn">Cập nhật trạng thái</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function fetchAllOrders() {
            try {
                const response = await fetch('http://localhost:3000/order-service/all');

                if (!response.ok) {
                    throw new Error('Không thể tải danh sách đơn hàng');
                }

                const orders = await response.json();
                renderOrders(orders);
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
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = '';

            const userCache = {};

            for (const item of orders) {
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

                const userName = user?.username || 'Không rõ';
                const paymentStatus = order.payment_status || 'pending';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${order.order_id}</td>
                    <td>${userName}</td>
                    <td>${new Date(order.updated_at).toLocaleDateString()}</td>
                    <td>${Number(order.total_price || 0).toLocaleString()} đ</td>
                    <td>
                        <span class="status-badge status-${order.status}">${getStatusText(order.status)}</span>
                        <div class="status-actions">
                            ${order.status === 'pending' ? `
                            <button class="confirm-btn" onclick="confirmOrder(${order.order_id})" title="Xác nhận đơn hàng">
                                <i class="fas fa-check-circle"></i>
                            </button>` : ''}
                            <button class="update-btn" onclick="showUpdateStatus(${order.order_id})" title="Chỉnh sửa trạng thái">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                    <td><span class="status-badge payment-status-${paymentStatus}">${getPaymentStatusText(paymentStatus)}</span></td>
                    <td>
                        <div class="action-buttons">
                            ${paymentStatus === 'pending' ? `
                            <button class="confirm-payment-btn" onclick="confirmPayment(${order.order_id})" title="Xác nhận thanh toán">
                                <i class="fas fa-check-circle"></i>
                            </button>` : ''}
                            <button class="edit-payment-btn" onclick="showUpdatePaymentStatus(${order.order_id})" title="Chỉnh sửa trạng thái thanh toán">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            }
        }

        function getStatusText(status) {
            if (!status) return 'Không xác định';
            const statusMap = {
                pending: "Chờ xử lý",
                processing: "Đang xử lý",
                completed: "Hoàn thành",
                canceled: "Đã hủy"
            };
            return statusMap[status.toLowerCase()] || status;
        }

        function getPaymentStatusText(status) {
            const statusMap = {
                pending: "Chờ thanh toán",
                paid: "Đã thanh toán"
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
                    console.error(`Failed to fetch order details. Status: ${response.status}`); // Log status code
                    throw new Error(`Không thể tải chi tiết đơn hàng. Mã lỗi: ${response.status}`);
                }

                const order = await response.json();
                console.log('Order details fetched successfully:', order); // Log fetched order details

                displayOrderDetails(order);
                document.getElementById('orderModal').style.display = 'block';
            } catch (error) {
                console.error('Lỗi khi tải chi tiết đơn hàng:', error); // Log error details
                alert('Không thể tải chi tiết đơn hàng. Vui lòng thử lại sau.');
            }
        }

        document.addEventListener('DOMContentLoaded', fetchAllOrders);



        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
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
            document.getElementById('orderTotal').textContent = formatCurrency(order.order.total_price);

            // Hiển thị thông tin khách hàng nếu có
            document.getElementById('customerName').textContent =  user.username || 'Không xác định';
            document.getElementById('customerEmail').textContent =  user.email || 'Không xác định';
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
        } else {
            const row = document.createElement('tr');
            row.innerHTML = '<td colspan="4">Không có sản phẩm</td>';
            productsList.appendChild(row);
        }

            // Đặt lại giá trị cho select trạng thái
            if (order.status) {
                document.getElementById('updateStatus').value = order.status.toLowerCase();
            }
        }

        async function updateOrderStatus(orderId) {
            try {
                const newStatus = document.getElementById('updateStatus').value;
                const response = await fetch(`http://localhost:3000/order-service/${orderId}/status/${newStatus}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Không thể cập nhật trạng thái đơn hàng');
                }

                const result = await response.json();
                showMessage(result.message || 'Cập nhật trạng thái thành công');
                fetchAllOrders(); // Reload the order list after updating
            } catch (error) {
                console.error('Lỗi khi cập nhật trạng thái đơn hàng:', error);
                showMessage('Không thể cập nhật trạng thái đơn hàng. Vui lòng thử lại sau.', true);
            }
        }

        function showUpdateStatus(orderId) {
            // Gọi hàm viewOrderDetails để tải thông tin chi tiết đơn hàng
            viewOrderDetails(orderId);

            const modal = document.getElementById('orderModal');
            modal.style.display = 'block';

            const updateStatusSelect = document.getElementById('updateStatus');
            updateStatusSelect.value = '';

            // Đảm bảo nút cập nhật trạng thái nhận đúng orderId
            const updateButton = modal.querySelector('.update-btn');
            updateButton.onclick = function() {
                updateOrderStatus(orderId);
            };
        }

        function closeModal() {
            const modal = document.getElementById('orderModal');
            modal.style.display = 'none';
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
            const userName = document.getElementById('userNameSearch').value.trim();

            if (!userName) {
                // Nếu không nhập Tên User, trả về danh sách tất cả đơn hàng
                fetchAllOrders();
                return;
            }

            try {
                // Gửi yêu cầu để lấy user_id từ tên user
                const userResponse = await fetch(`http://localhost:3000/user-service/users/username/${userName}`);

                if (!userResponse.ok) {
                    throw new Error('Không thể tìm thấy user với tên đã nhập');
                }

                const user = await userResponse.json();

                if (!user || !user.user_id) {
                    throw new Error('User ID không hợp lệ hoặc không tồn tại');
                }

                const userId = user.user_id; // Sử dụng thuộc tính user_id trả về từ API

                // Sử dụng user_id để lấy danh sách đơn hàng
                const orderResponse = await fetch(`http://localhost:3000/order-service/user/${userId}`);

                if (!orderResponse.ok) {
                    throw new Error('Không thể tìm kiếm đơn hàng theo User ID');
                }

                const orders = await orderResponse.json();
                renderOrders(orders); // Hiển thị danh sách đơn hàng được tìm kiếm
            } catch (error) {
                console.error('Lỗi khi tìm kiếm đơn hàng theo Tên User:', error);
                alert(error.message || 'Không thể tìm kiếm đơn hàng. Vui lòng thử lại sau.');
            }
        }

        async function confirmPayment(orderId) {
            try {
                const response = await fetch(`http://localhost:3000/order-service/${orderId}/payment/paid`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    }
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

        async function showUpdatePaymentStatus(orderId) {
            viewOrderDetails(orderId);
            const modal = document.getElementById('orderModal');
            modal.style.display = 'block';

            // Thêm select box cho trạng thái thanh toán vào modal
            const paymentStatusSelect = document.createElement('select');
            paymentStatusSelect.id = 'updatePaymentStatus';
            paymentStatusSelect.innerHTML = `
                <option value="pending">Chờ thanh toán</option>
                <option value="paid">Đã thanh toán</option>
            `;

            const updateButton = document.createElement('button');
            updateButton.className = 'update-btn';
            updateButton.textContent = 'Cập nhật trạng thái thanh toán';
            updateButton.onclick = () => updatePaymentStatus(orderId);

            const paymentStatusContainer = document.createElement('div');
            paymentStatusContainer.className = 'payment-status-update mb-3';
            paymentStatusContainer.appendChild(paymentStatusSelect);
            paymentStatusContainer.appendChild(updateButton);

            const orderActions = document.querySelector('.order-actions');
            orderActions.appendChild(paymentStatusContainer);
        }

        async function updatePaymentStatus(orderId) {
            try {
                const newStatus = document.getElementById('updatePaymentStatus').value;
                const response = await fetch(`http://localhost:3000/order-service/${orderId}/payment/${newStatus}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Không thể cập nhật trạng thái thanh toán');
                }

                const result = await response.json();
                showMessage(result.message || 'Cập nhật trạng thái thanh toán thành công');
                fetchAllOrders();
                closeModal();
            } catch (error) {
                console.error('Lỗi khi cập nhật trạng thái thanh toán:', error);
                showMessage('Không thể cập nhật trạng thái thanh toán. Vui lòng thử lại sau.', true);
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
    </script>
</body>

</html>