<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="sidebar.css">
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

            <div class="stat-card" onclick="window.location.href='order_management.php'">
                <i class="fas fa-shopping-cart icon"></i>
                <h3>Đơn hàng mới</h3>
                <div class="number" id="orderCount">0</div>
            </div>

            <div class="stat-card" onclick="window.location.href='product_management.php'">
                <i class="fas fa-box icon"></i>
                <h3>Sản phẩm</h3>
                <div class="number" id="productCount">0</div>
            </div>

            <div class="stat-card" onclick="window.location.href='pages/report.php'">
                <i class="fas fa-dollar-sign icon"></i>
                <h3>Doanh thu tháng này</h3>
                <div class="number" id="revenue">0đ</div>
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

                // Lấy thống kê khác từ API
                const response = await fetch('http://localhost:3000/admin/dashboard-stats', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.status === 403) {
                    alert('Bạn không có quyền truy cập trang này');
                    window.location.href = '../login.php';
                    return;
                }

                if (response.ok) {
                    const stats = await response.json();
                    // Cập nhật số liệu thống kê
                    document.getElementById('orderCount').textContent = stats.orderCount || 0;
                    document.getElementById('productCount').textContent = stats.productCount || 0;
                    document.getElementById('revenue').textContent = 
                        new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' })
                            .format(stats.revenue || 0);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
</body>
</html>
