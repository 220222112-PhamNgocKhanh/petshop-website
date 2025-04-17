<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <ul>
            <li class="active"><i class="fas fa-box"></i> <a href="product_management.html">Quản lý sản phẩm</a></li>
            <li><i class="fas fa-shopping-cart"></i> <a href="order_management.html">Quản lý đơn hàng</a></li>
            <li><i class="fas fa-users"></i> <a href="customer_management.html">Quản lý khách hàng</a></li>
            <li><i class="fas fa-edit"></i> <a href="blog_management.php">Quản lý bài viết</a></li>
            <li><i class="fas fa-chart-bar"></i> <a href="report_management.php">Thống kê & Báo cáo</a></li>
            <li><i class="fas fa-sign-out-alt"></i> <a href="#" onclick="logout()">Đăng xuất</a></li>


        </ul>
    </div>
    <div class="content">
        <h1>Dashboard Admin</h1>
        <div class="charts">
            <canvas id="revenueChart"></canvas>
            <canvas id="orderChart"></canvas>
        </div>
    </div>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        }
        
        // Biểu đồ thống kê doanh thu
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                datasets: [{
                    label: 'Doanh thu (triệu VND)',
                    data: [50, 75, 100, 90, 120, 140],
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });
        
        // Biểu đồ số lượng đơn hàng
        const orderCtx = document.getElementById('orderChart').getContext('2d');
        new Chart(orderCtx, {
            type: 'bar',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                datasets: [{
                    label: 'Số đơn hàng',
                    data: [120, 150, 180, 160, 200, 220],
                    backgroundColor: 'orange'
                }]
            }
        });
        function logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        window.location.href = '../login.php'; // hoặc trang đăng nhập của bạn
    }
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
