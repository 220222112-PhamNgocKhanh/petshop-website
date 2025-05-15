/**
 * CartUI: Module xử lý hiển thị giỏ hàng trên UI
 */
const CartUI = {
  /**
   * Phí vận chuyển mặc định
   */
  SHIPPING_FEE: 5.00,
  
  /**
   * Hiển thị thông báo toast
   * @param {string} message Nội dung thông báo
   * @param {number} duration Thời gian hiển thị (ms)
   */
  showToast(message, duration = 3000) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
      toast.classList.add('show');
    }, 100);
    
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => {
        document.body.removeChild(toast);
      }, 300);
    }, duration);
  },
  
  /**
   * Format số tiền
   * @param {number} amount Số tiền
   * @returns {string} Chuỗi tiền đã format
   */
  formatCurrency(amount) {
    return '$' + amount.toFixed(2);
  },
  
  /**
   * Load và hiển thị giỏ hàng
   */
  async loadCartItems() {
    // Lấy các element cần thiết
    const cartBody = document.getElementById('cart-body');
    const emptyCart = document.querySelector('.empty-cart');
    const cartTable = document.querySelector('.cart-table');
    const cartSummary = document.querySelector('.cart-summary');
    
    if (!cartBody) {
      console.error('Không tìm thấy element cart-body');
      return;
    }
    
    if (!emptyCart) {
      console.error('Không tìm thấy element empty-cart');
    }
    
    if (!cartTable) {
      console.error('Không tìm thấy element cart-table');
    }
    
    if (!cartSummary) {
      console.error('Không tìm thấy element cart-summary');
    }
    
    // Lấy giỏ hàng từ localStorage
    let cartItems = CartManager.getCart();
    console.log('Cart items:', cartItems);
    
    // Nếu người dùng đã đăng nhập, đồng bộ với server
    if (CartAPI.isAuthenticated()) {
      try {
        await CartManager.syncCartFromAPI();
        cartItems = CartManager.getCart();
        console.log('Cart items after sync:', cartItems);
      } catch (error) {
        console.error('Lỗi khi đồng bộ giỏ hàng:', error);
      }
    }
    
    // Hiển thị UI tương ứng
    if (!cartItems || cartItems.length === 0) {
      console.log('Giỏ hàng trống, hiển thị thông báo trống');
      // Hiển thị thông báo giỏ hàng trống
      if (emptyCart) emptyCart.style.display = 'block';
      if (cartTable) cartTable.style.display = 'none';
      if (cartSummary) cartSummary.style.display = 'none';
      return;
    }
    
    console.log('Giỏ hàng có sản phẩm, hiển thị bảng');
    // Hiển thị giỏ hàng có sản phẩm
    if (emptyCart) emptyCart.style.display = 'none';
    if (cartTable) cartTable.style.display = 'table';
    if (cartSummary) cartSummary.style.display = 'block';
    
    // Xóa các sản phẩm cũ (nếu có)
    cartBody.innerHTML = '';
    
    // Tổng tiền hàng
    let subtotal = 0;
    
    // Render sản phẩm vào giỏ hàng
    cartItems.forEach(product => {
      try {
        const row = document.createElement('tr');
        row.className = 'cart-item';
        row.dataset.id = product.id;
        
        const itemTotal = product.price * product.quantity;
        subtotal += itemTotal;
        
        row.innerHTML = `
          <td>
            <img src="../backend/image/${product.category || 'default'}/${product.image || 'default-product.jpg'}" 
                alt="${product.name}"
                loading="lazy"
                decoding="async"
                onerror="this.onerror=null; this.src='../backend/image/default-product.jpg';">
          </td>
          <td class="cart-item-name">${product.name}</td>
          <td class="cart-item-price">${this.formatCurrency(product.price)}</td>
          <td class="cart-item-quantity">
            <div class="quantity-control">
              <button class="quantity-btn minus-btn">-</button>
              <input type="number" class="quantity-input" id="quantity-${product.id}" name="quantity-${product.id}" value="${product.quantity}" min="1" max="99">
              <button class="quantity-btn plus-btn">+</button>
            </div>
          </td>
          <td class="cart-item-total">${this.formatCurrency(itemTotal)}</td>
          <td class="cart-item-action">
            <button class="remove-btn"><i class="fas fa-trash"></i></button>
          </td>
        `;
        
        cartBody.appendChild(row);
        
        // Thêm hiệu ứng xuất hiện cho sản phẩm
        setTimeout(() => {
          row.classList.add('show');
        }, 10);
        
        // Xử lý các nút tăng/giảm số lượng
        const minusBtn = row.querySelector('.minus-btn');
        const plusBtn = row.querySelector('.plus-btn');
        const quantityInput = row.querySelector('.quantity-input');
        const removeBtn = row.querySelector('.remove-btn');
        
        minusBtn.addEventListener('click', () => {
          if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            this.updateQuantity(product.id, parseInt(quantityInput.value));
          }
        });
        
        plusBtn.addEventListener('click', () => {
          quantityInput.value = parseInt(quantityInput.value) + 1;
          this.updateQuantity(product.id, parseInt(quantityInput.value));
        });
        
        quantityInput.addEventListener('change', () => {
          const newValue = parseInt(quantityInput.value);
          if (newValue < 1) quantityInput.value = 1;
          if (newValue > 99) quantityInput.value = 99;
          this.updateQuantity(product.id, parseInt(quantityInput.value));
        });
        
        removeBtn.addEventListener('click', () => {
          this.removeItem(product.id);
        });
      } catch (error) {
        console.error('Lỗi khi render sản phẩm:', product, error);
      }
    });
    
    // Cập nhật tổng tiền
    this.updateCartSummary(subtotal);
    console.log('Đã cập nhật tổng tiền:', subtotal);
  },
  
  /**
   * Cập nhật số lượng sản phẩm
   * @param {number} productId ID sản phẩm
   * @param {number} quantity Số lượng mới
   */
  async updateQuantity(productId, quantity) {
    // Cập nhật trong CartManager
    const success = await CartManager.updateCartItem(productId, quantity);
    
    if (success) {
      // Cập nhật UI
      const row = document.querySelector(`.cart-item[data-id="${productId}"]`);
      if (row) {
        const priceCell = row.querySelector('.cart-item-price');
        const price = parseFloat(priceCell.textContent.replace('$', ''));
        const totalCell = row.querySelector('.cart-item-total');
        const newTotal = price * quantity;
        
        totalCell.textContent = this.formatCurrency(newTotal);
        
        // Cập nhật tổng tiền
        this.updateCartTotals();
      }
    }
  },
  
  /**
   * Xóa sản phẩm khỏi giỏ hàng
   * @param {number} productId ID sản phẩm
   */
  async removeItem(productId) {
    // Xóa từ CartManager
    const success = await CartManager.removeFromCart(productId);
    
    if (success) {
      window.updateCartCount();
      
      // Xóa dòng sản phẩm với hiệu ứng
      const row = document.querySelector(`.cart-item[data-id="${productId}"]`);
      if (row) {
        row.classList.add('fade-out');
        
        setTimeout(() => {
          row.remove();
          
          // Kiểm tra nếu giỏ hàng trống
          const cartItems = CartManager.getCart();
          if (cartItems.length === 0) {
            document.querySelector('.empty-cart').style.display = 'block';
            document.querySelector('.cart-table').style.display = 'none';
            document.querySelector('.cart-summary').style.display = 'none';
          } else {
            // Cập nhật tổng tiền
            this.updateCartTotals();
          }
        }, 300);
      }
    }
  },
  
  /**
   * Cập nhật tổng tiền
   */
  updateCartTotals() {
    let subtotal = 0;
    document.querySelectorAll('.cart-item').forEach(row => {
      const totalText = row.querySelector('.cart-item-total').textContent;
      subtotal += parseFloat(totalText.replace('$', ''));
    });
    
    this.updateCartSummary(subtotal);
  },
  
  /**
   * Cập nhật phần tổng kết giỏ hàng
   * @param {number} subtotal Tổng tiền hàng
   */
  updateCartSummary(subtotal) {
    const total = subtotal + this.SHIPPING_FEE;
    
    document.getElementById('subtotal-amount').textContent = this.formatCurrency(subtotal);
    document.getElementById('shipping-amount').textContent = this.formatCurrency(this.SHIPPING_FEE);
    document.getElementById('total-amount').textContent = this.formatCurrency(total);
  },
  
  /**
   * Khởi tạo trang giỏ hàng
   */
  initCartPage() {
    // Load giỏ hàng
    this.loadCartItems();
    
    // Xử lý nút checkout
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
      checkoutBtn.addEventListener('click', () => {
        const cartItems = CartManager.getCart();
        if (cartItems.length > 0) {
          window.location.href = 'checkout.php';
        } else {
          this.showToast('Giỏ hàng của bạn đang trống!');
        }
      });
    }
    
    // Lắng nghe sự kiện thay đổi giỏ hàng từ tab khác
    /*
    window.addEventListener('storage', (event) => {
      if (event.key === 'cart') {
        this.loadCartItems();
      }
    });
    */
  }
};

// Export module để sử dụng trong các file khác
window.CartUI = CartUI;

// Khởi tạo trang giỏ hàng khi document ready
document.addEventListener('DOMContentLoaded', () => {
  // Kiểm tra nếu đang ở trang giỏ hàng
  if (document.getElementById('cart-body')) {
    CartUI.initCartPage();
  }
}); 