<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 1.1em;
        }

        .stat-card .number {
            font-size: 2em;
            color: #3498db;
            font-weight: bold;
        }

        .stat-card .icon {
            float: right;
            font-size: 2.5em;
            color: rgba(52, 152, 219, 0.2);
        }

        .welcome-message {
            background: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .welcome-message h2 {
            margin: 0;
            font-size: 1.5em;
        }

        .welcome-message p {
            margin: 10px 0 0 0;
            opacity: 0.8;
        }

        .statistics-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .statistics-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .statistics-header h2 {
            margin: 0;
            color: #2c3e50;
        }

        .time-filter {
            display: flex;
            gap: 10px;
        }

        .time-filter button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            background: #f0f0f0;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .time-filter button:hover {
            background: #e0e0e0;
        }

        .time-filter button.active {
            background: #3498db;
            color: white;
        }

        .statistics-table {
            margin-top: 20px;
            overflow-x: auto;
        }

        .statistics-table table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .statistics-table th,
        .statistics-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .statistics-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .statistics-table tr:hover {
            background: #f8f9fa;
        }

        .stat-category {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-category i {
            font-size: 1.2em;
            color: #3498db;
            width: 24px;
            text-align: center;
        }

        .stat-category span {
            font-weight: 500;
            color: #2c3e50;
        }

        #newUsersTotal,
        #newOrdersTotal,
        #newProductsTotal,
        #revenueTotal {
            font-weight: 600;
            color: #2c3e50;
        }

        #newUsersDetail,
        #newOrdersDetail,
        #newProductsDetail,
        #revenueDetail {
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="content">
        <div class="welcome-message">
            <h2>Chào mừng đến với Trang quản trị</h2>
            <p>Quản lý và theo dõi hoạt động của cửa hàng thú cưng của bạn</p>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card" onclick="window.location.href='customer_management.php'">
                <i class="fas fa-users icon"></i>
                <h3>Tổng số khách hàng</h3>
                <div class="number" id="userCount">0</div>
            </div>

            <div class="stat-card" onclick="window.location.href='order_management.php?status=pending'">
                <i class="fas fa-shopping-cart icon"></i>
                <h3>Đơn hàng mới</h3>
                <div class="number" id="orderCount">0</div>
            </div>

            <div class="stat-card" onclick="window.location.href='product_management.php'">
                <i class="fas fa-box icon"></i>
                <h3>Sản phẩm</h3>
                <div class="number" id="productCount">0</div>
            </div>

            <!-- <div class="stat-card" onclick="window.location.href='pages/report.php'">
                <i class="fas fa-dollar-sign icon"></i>
                <h3>Doanh thu tháng này</h3>
                <div class="number" id="revenue">0đ</div>
            </div> -->
        </div>

        <div class="statistics-section">
            <div class="statistics-header">
                <h2>Thống kê</h2>
                <div class="time-filter">
                    <button data-time="today" class="active">Hôm nay</button>
                    <button data-time="week">Tuần này</button>
                    <button data-time="month">Tháng này</button>
                    <button data-time="year">Năm nay</button>
                </div>
            </div>
            <div class="statistics-table">
                <table>
                    <thead>
                        <tr>
                            <th>Danh mục</th>
                            <th>Tổng số</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="stat-category">
                                    <i class="fas fa-users"></i>
                                    <span>Người dùng mới</span>
                                </div>
                            </td>
                            <td id="newUsersTotal">0</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="stat-category">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Đơn hàng mới</span>
                                </div>
                            </td>
                            <td id="newOrdersTotal">0</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="stat-category">
                                    <i class="fas fa-box"></i>
                                    <span>Sản phẩm mới</span>
                                </div>
                            </td>
                            <td id="newProductsTotal">0</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="stat-category">
                                    <i class="fas fa-dollar-sign"></i>
                                    <span>Doanh thu</span>
                                </div>
                            </td>
                            <td id="revenueTotal">0$</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            // Kiểm tra đăng nhập
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '../login.php';
                return;
            }

            try {
                // Lấy số lượng người dùng
                const userCountResponse = await fetch('http://localhost:3000/user-service/users/count', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (userCountResponse.ok) {
                    const userCountData = await userCountResponse.json();
                    document.getElementById('userCount').textContent = userCountData.count || 0;
                }

                // Lấy tổng số sản phẩm
                const productCountResponse = await fetch('http://localhost:3000/product-service/products/count', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (productCountResponse.ok) {
                    const productCountData = await productCountResponse.json();
                    document.getElementById('productCount').textContent = productCountData.total || 0;
                }

                // Lấy tổng số đơn hàng pending
                const pendingOrdersResponse = await fetch('http://localhost:3000/order-service/count/pending', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (pendingOrdersResponse.ok) {
                    const pendingOrdersData = await pendingOrdersResponse.json();
                    document.getElementById('orderCount').textContent = pendingOrdersData.total || 0;
                }

                // Load dữ liệu ban đầu với timeRange là 'today'
                updateStatistics('today');

            } catch (error) {
                console.error('Error:', error);
            }
        });

        async function updateStatistics(timeRange) {
            const token = localStorage.getItem('token');
            
            // Cập nhật active button
            document.querySelectorAll('.time-filter button').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-time') === timeRange) {
                    btn.classList.add('active');
                }
            });

            try {
                // Lấy thống kê người dùng mới
                const newUsersResponse = await fetch(`http://localhost:3000/user-service/stats/new-users?timeRange=${timeRange}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (newUsersResponse.ok) {
                    const newUsersData = await newUsersResponse.json();
                    document.getElementById('newUsersTotal').textContent = newUsersData.totalNewUsers || 0;
                }

                // Lấy thống kê sản phẩm mới
                const newProductsResponse = await fetch(`http://localhost:3000/product-service/products/new-stats?timeRange=${timeRange}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (newProductsResponse.ok) {
                    const newProductsData = await newProductsResponse.json();
                    document.getElementById('newProductsTotal').textContent = newProductsData.totalNewProducts || 0;
                }

                // Lấy thống kê đơn hàng và doanh thu
                const orderStatsResponse = await fetch(`http://localhost:3000/order-service/stats/count?period=${timeRange}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (orderStatsResponse.ok) {
                    const orderStatsData = await orderStatsResponse.json();
                    
                    // Cập nhật số đơn hàng mới
                    document.getElementById('newOrdersTotal').textContent = orderStatsData.total || 0;
                    
                    // Cập nhật doanh thu - hiển thị chính xác số tiền và đơn vị $
                    const revenue = orderStatsData.revenue || 0;
                    document.getElementById('revenueTotal').textContent = 
                        new Intl.NumberFormat('en-US', { 
                            style: 'currency', 
                            currency: 'USD',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(revenue);
                }

            } catch (error) {
                console.error('Error updating statistics:', error);
            }
        }

        // Thêm event listeners cho các nút
        document.addEventListener('DOMContentLoaded', function() {
            const timeFilterButtons = document.querySelectorAll('.time-filter button');
            timeFilterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const timeRange = this.getAttribute('data-time');
                    updateStatistics(timeRange);
                });
            });
        });
    </script>
</body>
</html>
