<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Báo cáo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="sidebar.css">
    <style>
        .content {
            /* margin-left: 260px; Phù hợp với chiều rộng của sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .report-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .report-filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .filter-group select, .filter-group input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 150px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .report-table th, .report-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .report-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .report-table tr:hover {
            background-color: #f5f5f5;
        }

        .export-btn {
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

        .export-btn:hover {
            background: #218838;
        }

        .chart-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .chart-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 400px; /* Cố định chiều cao */
            position: relative; /* Thêm position relative */
        }

        .chart-box canvas {
            max-height: 350px !important; /* Cố định chiều cao tối đa cho canvas */
            width: 100% !important;
            height: 100% !important;
        }

        .chart-box h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        @media screen and (max-width: 768px) {
            .chart-container {
                grid-template-columns: 1fr;
            }
            
            .report-filters {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="content">
        <div class="report-container">
            <div class="report-header">
                <h1>Báo cáo Thống kê</h1>
                <button class="export-btn">
                    <i class="fas fa-download"></i>
                    Xuất báo cáo
                </button>
            </div>

            <div class="report-filters">
                <div class="filter-group">
                    <label>Thời gian</label>
                    <select id="timeFilter">
                        <option value="today">Hôm nay</option>
                        <option value="week">Tuần này</option>
                        <option value="month">Tháng này</option>
                        <option value="year">Năm nay</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Từ ngày</label>
                    <input type="date" id="startDate">
                </div>

                <div class="filter-group">
                    <label>Đến ngày</label>
                    <input type="date" id="endDate">
                </div>
            </div>

            <table class="report-table">
                <thead>
                    <tr>
                        <th>Chỉ số</th>
                        <th>Giá trị</th>
                        <th>So với kỳ trước</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tổng doanh thu</td>
                        <td>0 VNĐ</td>
                        <td>0%</td>
                    </tr>
                    <tr>
                        <td>Số đơn hàng</td>
                        <td>0</td>
                        <td>0%</td>
                    </tr>
                    <tr>
                        <td>Khách hàng mới</td>
                        <td>0</td>
                        <td>0%</td>
                    </tr>
                </tbody>
            </table>

            <div class="chart-container">
                <div class="chart-box">
                    <h3>Biểu đồ doanh thu</h3>
                    <canvas id="revenueChart"></canvas>
                </div>
                <div class="chart-box">
                    <h3>Biểu đồ đơn hàng</h3>
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo biểu đồ doanh thu
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    datasets: [{
                        label: 'Doanh thu',
                        data: [0, 0, 0, 0, 0, 0, 0],
                        borderColor: '#4e73df',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Khởi tạo biểu đồ đơn hàng
            const orderCtx = document.getElementById('orderChart').getContext('2d');
            new Chart(orderCtx, {
                type: 'bar',
                data: {
                    labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    datasets: [{
                        label: 'Số đơn hàng',
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: '#1cc88a'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Xử lý sự kiện thay đổi bộ lọc thời gian
            document.getElementById('timeFilter').addEventListener('change', function() {
                updateReport();
            });

            // Xử lý sự kiện thay đổi ngày
            document.getElementById('startDate').addEventListener('change', function() {
                updateReport();
            });

            document.getElementById('endDate').addEventListener('change', function() {
                updateReport();
            });

            // Hàm cập nhật báo cáo
            function updateReport() {
                // Thêm code xử lý cập nhật dữ liệu báo cáo tại đây
                console.log('Updating report...');
            }

            // Xử lý sự kiện xuất báo cáo
            document.querySelector('.export-btn').addEventListener('click', function() {
                // Thêm code xử lý xuất báo cáo tại đây
                console.log('Exporting report...');
            });
        });
    </script>
</body>
</html>
