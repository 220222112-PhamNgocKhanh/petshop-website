<div id="header">
    <a href="index.php" id="logo"><img src="images/logo.jpg"  width="310" height="114" alt="Pet Shop"></a>
    <ul class="navigation">
        <li><a href="index.php">Home</a></li>
        <li><a href="petmart.php">PetMart</a></li>
        <li><a href="about.php">About us</a></li>
        <li><a href="blog.php">Blog</a></li>
        <li><a href="petguide.php">PetGuide</a></li>
        <li><a href="contact.php">Contact us</a></li>
        <div id="userSection"></div> <!-- Phần này sẽ được cập nhật bằng JavaScript -->
    </ul>
</div>

<!-- Thêm Font Awesome để sử dụng icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Thêm JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const userSection = document.getElementById('userSection');
        const token = localStorage.getItem('token'); // Kiểm tra token trong localStorage

        if (token) {
            // Nếu đã đăng nhập, hiển thị menu thả xuống
            userSection.innerHTML = `
                <div class="user-dropdown">
                    <a href="#" id="userIcon"><img src="images/login.png" height="25" width="25" onclick="toggleDropdown(event)"></a>
                    <div id="userDropdown" class="dropdown-content">
                        <a href="account.php"><i class="fa fa-user"></i> Account</a>
                        <a href="cart.php" class="cart-link"><i class="fa fa-shopping-cart"></i> Shopping cart <span id="cart-count" class="cart-count">0</span></a>
                        <a href="order.php"><i class="fa fa-list-alt"></i> Order</a>
                        <a href="#" id="logoutButton"><i class="fa fa-sign-out"></i> Log out</a>
                    </div>
                </div>
            `;
            await updateCartCount();

            // Xử lý sự kiện Log out
            const logoutButton = document.getElementById('logoutButton');
            logoutButton.addEventListener('click', (event) => {
                event.preventDefault();
                // Xóa token và giỏ hàng khỏi localStorage
                localStorage.removeItem('cart');
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                alert('You have been logged out.');
                // Chuyển hướng đến trang đăng nhập
                window.location.href = 'login.php';
            });
        } else {
            // Nếu chưa đăng nhập, chỉ hiển thị biểu tượng Login 
            userSection.innerHTML = `
                <a href="login.php"><img src="images/login.png" height="25" width="25" alt="Login"></a>
            `;
        }
    });

    // Cập nhật số lượng sản phẩm trong giỏ hàng từ API
    async function updateCartCount() {
        
        try {
            const cartCount = document.getElementById('cart-count');
            
            
            if (!cartCount) {
                console.warn("Không tìm thấy element cart-count");
                return;
            }
            
            let totalItems = 0;
            
            // Lấy từ localStorage trước để đảm bảo UI cập nhật nhanh
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.forEach(item => {
                totalItems += item.quantity || 1;
            });
            
            
            // Cập nhật UI trước
            cartCount.textContent = totalItems;
            cartCount.style.display = totalItems > 0 ? 'inline-block' : 'none';
            
            // Sau đó kiểm tra API nếu cần
            if (typeof window.CartAPI !== 'undefined' && window.CartAPI && typeof window.CartAPI.isAuthenticated === 'function' && window.CartAPI.isAuthenticated()) {
                // Lấy số lượng từ API để so sánh
                const apiTotal = await window.CartAPI.getCartCount();
             
                
                // Nếu có sự khác biệt, cập nhật lại UI
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
        document.getElementById("userDropdown").classList.toggle("show");
    }

    // Đóng menu thả xuống khi click ra ngoài
    window.onclick = function(event) {
        if (!event.target.matches('#userIcon img')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    
    // Đăng ký sự kiện lắng nghe thay đổi giỏ hàng
    document.addEventListener('cartUpdated', async function() {
        await updateCartCount();
    });
    
    // Lắng nghe sự kiện thay đổi từ localStorage (cho tab khác)
    window.addEventListener('storage', async function(event) {
        if (event.key === 'cart') {
            await updateCartCount();
        }
    });

    // Đưa hàm updateCartCount lên global scope để các module khác có thể gọi
    window.updateCartCount = updateCartCount;
</script>