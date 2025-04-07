<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê Doanh thu</title>
    <link rel="stylesheet" href="admin.css">
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
        </ul>
    </div>
    <div class="content">
        <h1>Thống kê Doanh thu</h1>
        <canvas id="revenueChart"></canvas>
    </div>
    <script>
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'pie',
            data: {
                labels: ['Bán hàng online', 'Bán tại cửa hàng', 'Dịch vụ khác'],
                datasets: [{
                    label: 'Tỷ lệ doanh thu',
                    data: [50, 35, 15],
                    backgroundColor: ['blue', 'orange', 'green']
                }]
            }
        });
    </script>
</body>
</html>
