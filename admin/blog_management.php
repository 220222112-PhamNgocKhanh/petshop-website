<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Bài viết</title>
    <link rel="stylesheet" href="test.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
        <h1>Quản lý Bài viết</h1>
        <button onclick="addPost()">Thêm bài viết</button>
        <table>
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Tác giả</th>
                    <th>Ngày đăng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="postTable">
                <tr>
                    <td>Bài viết mẫu</td>
                    <td>Admin</td>
                    <td>01/04/2025</td>
                    <td>
                        <button onclick="editPost()">Sửa</button>
                        <button onclick="deletePost()">Xóa</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        function addPost() {
            alert("Thêm bài viết mới");
        }
        function editPost() {
            alert("Sửa bài viết");
        }
        function deletePost() {
            alert("Xóa bài viết");
        }
    </script>
</body>
</html>