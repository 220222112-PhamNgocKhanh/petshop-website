<?php
// Lấy tên file hiện tại để đánh dấu menu active
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Thanh trigger để hover -->
<div class="sidebar-trigger"></div>

<div class="sidebar">
    <div class="logo-details">
        <a href="admin.php">
            <img src="../images/logo.jpg" alt="Logo" class="logo-img" width="230" height="120">
        </a>
        <i class='bx bx-menu' id="btn"></i>
    </div>
    
    <div class="admin-info">
        <div class="admin-details">
            <small class="admin-role">Quản trị viên</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li class="<?php echo ($current_page == 'admin.php') ? 'active' : ''; ?>">
                <a href="admin.php">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="<?php echo ($current_page == 'product_management.php') ? 'active' : ''; ?>">
                <a href="product_management.php">
                    <i class="fas fa-box"></i>
                    <span>Quản lý sản phẩm</span>
                </a>
            </li>
            
            <li class="<?php echo ($current_page == 'order_management.php') ? 'active' : ''; ?>">
                <a href="order_management.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Quản lý đơn hàng</span>
                </a>
            </li>
            
            <li class="<?php echo ($current_page == 'customer_management.php') ? 'active' : ''; ?>">
                <a href="customer_management.php">
                    <i class="fas fa-users"></i>
                    <span>Quản lý khách hàng</span>
                </a>
            </li>
            
            <li class="<?php echo ($current_page == 'blog_management.php') ? 'active' : ''; ?>">
                <a href="blog_management.php">
                    <i class="fas fa-edit"></i>
                    <span>Quản lý bài viết</span>
                </a>
            </li>
            
            <li class="<?php echo ($current_page == 'report_management.php') ? 'active' : ''; ?>">
                <a href="report_management.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>Thống kê & Báo cáo</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="logout-container">
        <a href="#" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i>
            Đăng xuất
        </a>
    </div>
</div>

<script>
function logout() {
    if (confirm('Bạn có chắc muốn đăng xuất?')) {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        window.location.href = '../login.php';
    }
}

function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.content').classList.toggle('expanded');
}

// Thêm class active khi hover
document.querySelectorAll('.sidebar-nav li').forEach(item => {
    item.addEventListener('mouseenter', function() {
        if (!this.classList.contains('active')) {
            this.classList.add('hover');
        }
    });
    
    item.addEventListener('mouseleave', function() {
        this.classList.remove('hover');
    });
});

// Thêm class expanded cho content khi hover vào sidebar
document.querySelector('.sidebar').addEventListener('mouseenter', function() {
    document.querySelector('.content').classList.add('expanded');
});

document.querySelector('.sidebar').addEventListener('mouseleave', function() {
    document.querySelector('.content').classList.remove('expanded');
});

// Thêm event listeners để xử lý content
document.querySelector('.sidebar').addEventListener('mouseenter', function() {
    document.querySelector('.content').style.marginLeft = '270px';
});

document.querySelector('.sidebar').addEventListener('mouseleave', function() {
    document.querySelector('.content').style.marginLeft = '20px';
});

// Xử lý cho mobile
function checkMobile() {
    if (window.innerWidth <= 768) {
        document.querySelector('.content').style.marginLeft = '15px';
    }
}

window.addEventListener('resize', checkMobile);
checkMobile(); // Kiểm tra khi trang load
</script> 