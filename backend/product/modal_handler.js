document.addEventListener("click", async (e) => {
  if (e.target.closest(".view-detail-btn")) {
    const productId = e.target.closest(".view-detail-btn").getAttribute("data-id");

    try {
      const res = await fetch(`http://localhost:3000/product-service/products/${productId}`);
      const product = await res.json();
      const data = product.product;

      console.log("Dữ liệu sản phẩm:", data);
      document.getElementById('modal-body').innerHTML = `
      <div id="modal-body-content" class="product-modal-content">
        <div class="product-modal-grid">
          <div class="zoom-container">
            <img class="zoom-image product-image" 
                 src="../backend/image/${data.category}/${data.image || 'default-product.jpg'}" 
                 alt="${data.name}">
          </div>
          <div class="product-info">
            <h2 class="product-title">${data.name}</h2>
            <div class="product-price">
              ${Number(data.price).toLocaleString('en-US', { style: 'currency', currency: 'USD' })}
            </div>
            <div class="product-status ${data.amount > 0 ? 'in-stock' : 'out-of-stock'}">
              ${data.amount > 0 ? `<i class="fas fa-check-circle"></i> Còn ${data.amount} hàng` : '<i class="fas fa-times-circle"></i> Hết hàng'}
            </div>
            <div class="product-category">
              <span class="category-label">Danh mục:</span>
              <span class="category-value">${data.category}</span>
            </div>
            <div class="product-description">
              <h3>Mô tả sản phẩm</h3>
              <p>${data.description || 'Không có mô tả.'}</p>
            </div>
      
            ${data.amount > 0 ? `
              <div class="quantity-group">
                <label for="quantity">Số lượng:</label>
                <div class="quantity-controls">
                  <button class="quantity-btn minus">-</button>
                  <input type="number" id="quantity" min="1" max="${data.amount}" value="1">
                  <button class="quantity-btn plus">+</button>
                </div>
                <button id="addToCartBtn" class="add-to-cart-btn">
                  <i class="fas fa-shopping-cart"></i>
                  Thêm vào giỏ hàng
                </button>
              </div>
            ` : ''}
          </div>
        </div>
      </div>
      `;
      
      const zoomContainer = document.querySelector('.zoom-container');
      const zoomImage = document.querySelector('.zoom-image');
      
      // Cải thiện hiệu ứng zoom
      zoomContainer.addEventListener('mousemove', (e) => {
        const { left, top, width, height } = zoomContainer.getBoundingClientRect();
        const x = ((e.clientX - left) / width) * 100;
        const y = ((e.clientY - top) / height) * 100;
        zoomImage.style.transformOrigin = `${x}% ${y}%`;
        zoomImage.style.transform = 'scale(1.8)'; // Điều chỉnh mức zoom
      });
      
      zoomContainer.addEventListener('mouseleave', () => {
        zoomImage.style.transform = 'scale(1)';
        zoomImage.style.transformOrigin = 'center center';
      });

      // Quantity controls
      const quantityInput = document.getElementById('quantity');
      const minusBtn = document.querySelector('.minus');
      const plusBtn = document.querySelector('.plus');

      minusBtn?.addEventListener('click', () => {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
          quantityInput.value = currentValue - 1;
        }
      });

      plusBtn?.addEventListener('click', () => {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < data.amount) {
          quantityInput.value = currentValue + 1;
        }
      });
           
      document.getElementById("productModal").style.display = "block";
      document.getElementById("addToCartBtn")?.addEventListener("click", () => {
        // Kiểm tra đăng nhập trước khi thêm vào giỏ hàng
        const isLoggedIn = checkUserLogin();
        
        if (!isLoggedIn) {
          // Lưu URL hiện tại vào localStorage để sau khi đăng nhập có thể quay lại
          localStorage.setItem('redirectAfterLogin', window.location.href);
          
          // Thông báo cho người dùng
          alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng");
          
          // Đóng modal trước khi chuyển hướng
          document.getElementById("productModal").style.display = "none";
          
          // Chuyển hướng đến trang đăng nhập
          window.location.href = "../frontend/login.php";
          return;
        }
        
        const quantity = parseInt(document.getElementById("quantity").value);
        CartManager.addToCart(data, quantity);
        
        // Thêm thông báo thành công
        const toast = document.createElement('div');
        toast.className = 'toast success-toast';
        toast.innerHTML = `<i class="fas fa-check-circle"></i> Đã thêm ${quantity} sản phẩm vào giỏ hàng`;
        document.body.appendChild(toast);
        
        setTimeout(() => {
          toast.classList.add('show');
          
          // Kích hoạt cập nhật UI thủ công nếu cần
          if (typeof window.updateCartCount === "function") {
            window.updateCartCount();
          }
          
          setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
          }, 3000);
        }, 100);
      });
    } catch (error) {
      console.error("Lỗi khi tải dữ liệu sản phẩm:", error);
    }
  }
});

// Thêm hàm kiểm tra đăng nhập
function checkUserLogin() {
  // Kiểm tra xem người dùng đã đăng nhập chưa
  const user = localStorage.getItem('user') || sessionStorage.getItem('user');
  return !!user; // Trả về true nếu có thông tin người dùng, false nếu không
}

document.querySelector(".close").onclick = () => {
  document.getElementById("productModal").style.display = "none";
};

window.onclick = (e) => {
  const modal = document.getElementById("productModal");
  if (e.target === modal) {
    modal.style.display = "none";
  }
};