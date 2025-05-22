<?php
// Lấy tên trang hiện tại
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div id="header">
    <a href="index.php" id="logo"><img src="images/logo.jpg" alt="Pet Shop"></a>
    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
        <img src="images/menu.png" alt="Menu">
    </button>
    <ul class="navigation">
        <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="petmart.php" class="<?php echo $current_page == 'petmart.php' ? 'active' : ''; ?>">PetMart</a></li>
        <li><a href="about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About us</a></li>
        <li><a href="blog.php" class="<?php echo $current_page == 'blog.php' ? 'active' : ''; ?>">Blog</a></li>
        <li><a href="contact.php" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact us</a></li>
        <li id="userSection"></li>
    </ul>
</div>

<!-- Thêm Font Awesome để sử dụng icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Thêm JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const userSection = document.getElementById('userSection');
        const token = localStorage.getItem('token');

        if (token) {
            userSection.innerHTML = `
                <div class="user-dropdown">
                    <a href="#" id="userIcon"><img src="images/login.png" height="25" width="25" alt="User" onclick="toggleDropdown(event)"></a>
                    <div id="userDropdown" class="dropdown-content">
                        <a href="account.php"><i class="fa fa-user"></i> Account</a>
                        <a href="cart.php" class="cart-link"><i class="fa fa-shopping-cart"></i> Shopping cart <span id="cart-count" class="cart-count">0</span></a>
                        <a href="order.php"><i class="fa fa-list-alt"></i> Order</a>
                        <a href="#" id="logoutButton"><i class="fa fa-sign-out"></i> Log out</a>
                    </div>
                </div>
            `;
            await updateCartCount();

            const logoutButton = document.getElementById('logoutButton');
            logoutButton.addEventListener('click', (event) => {
                event.preventDefault();
                localStorage.removeItem('cart');
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                alert('You have been logged out.');
                window.location.href = 'login.php';
            });
        } else {
            userSection.innerHTML = `
                <a href="login.php" class="login-link"><img src="images/login.png" height="25" width="25" alt="Login"></a>
            `;
        }
    });

    // Toggle mobile menu
    function toggleMobileMenu() {
        const navigation = document.querySelector('.navigation');
        navigation.classList.toggle('show');
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const navigation = document.querySelector('.navigation');
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        
        if (!navigation.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
            navigation.classList.remove('show');
        }
    });

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    async function updateCartCount() {
        try {
            const cartCount = document.getElementById('cart-count');
            if (!cartCount) return;
            
            let totalItems = 0;
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.forEach(item => {
                totalItems += item.quantity || 1;
            });
            
            cartCount.textContent = totalItems;
            cartCount.style.display = totalItems > 0 ? 'inline-block' : 'none';
            
            if (typeof window.CartAPI !== 'undefined' && window.CartAPI && typeof window.CartAPI.isAuthenticated === 'function' && window.CartAPI.isAuthenticated()) {
                const apiTotal = await window.CartAPI.getCartCount();
                if (apiTotal !== totalItems) {
                    cartCount.textContent = apiTotal;
                    cartCount.style.display = apiTotal > 0 ? 'inline-block' : 'none';
                }
            }
        } catch (error) {
            console.error("Lỗi khi cập nhật số lượng giỏ hàng:", error);
        }
    }

    // Hiển thị/ẩn menu thả xuống
    function toggleDropdown(event) {
        event.preventDefault();
        const dropdown = document.getElementById("userDropdown");
        dropdown.classList.toggle("show");
    }

    // Đóng menu thả xuống khi click ra ngoài
    window.onclick = function(event) {
        if (!event.target.matches('#userIcon img')) {
            const dropdowns = document.getElementsByClassName("dropdown-content");
            for (let dropdown of dropdowns) {
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        }
    }
    
    // Đăng ký sự kiện lắng nghe thay đổi giỏ hàng
    document.addEventListener('cartUpdated', async function() {
        await updateCartCount();
    });
    
    // Lắng nghe sự kiện thay đổi từ localStorage
    window.addEventListener('storage', async function(event) {
        if (event.key === 'cart') {
            await updateCartCount();
        }
    });

    // Đưa hàm updateCartCount lên global scope
    window.updateCartCount = updateCartCount;
</script>