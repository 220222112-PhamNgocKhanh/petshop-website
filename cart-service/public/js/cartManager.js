/**
 * CartManager: Module quản lý giỏ hàng với localStorage và đồng bộ với API
 */
const CartManager = {
  /**
   * Lấy giỏ hàng từ localStorage
   * @returns {Array} Danh sách sản phẩm trong giỏ hàng
   */
  getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
  },

  /**
   * Lưu giỏ hàng vào localStorage
   * @param {Array} cart Danh sách sản phẩm trong giỏ hàng
   */
  saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Kích hoạt sự kiện "cartUpdated" để cập nhật UI ở tab hiện tại
    window.dispatchEvent(new CustomEvent('cartUpdated'));
    
    // Gọi trực tiếp hàm cập nhật nếu có
    if (typeof window.updateCartCount === 'function') {
      window.updateCartCount();
    }
  },

  /**
   * Tính tổng số lượng sản phẩm trong giỏ hàng
   * @returns {number} Tổng số lượng
   */
  getTotalItemsCount() {
    const cart = this.getCart();
    return cart.reduce((total, item) => total + (item.quantity || 1), 0);
  },

  /**
   * Tính tổng tiền của giỏ hàng
   * @returns {number} Tổng tiền
   */
  getCartTotal() {
    const cart = this.getCart();
    return cart.reduce((total, item) => total + (item.price * (item.quantity || 1)), 0);
  },

  /**
   * Hiển thị thông báo toast
   * @param {string} message Nội dung thông báo
   */
  showToast(message) {
    // Tạo element toast nếu chưa có
    let toast = document.getElementById('toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'toast';
      toast.className = 'toast';
      document.body.appendChild(toast);
    }
    
    // Hiển thị thông báo
    toast.textContent = message;
    toast.classList.add('show');
    
    // Ẩn thông báo sau 2.5 giây
    setTimeout(() => {
      toast.classList.remove('show');
    }, 2500);
  },

  /**
   * Thêm sản phẩm vào giỏ hàng
   * @param {Object} product Thông tin sản phẩm
   * @param {number} quantity Số lượng
   */
  async addToCart(product, quantity = 1) {
    // Lưu vào localStorage
    const cart = this.getCart();
    
    const existing = cart.find(item => item.id === product.id);
    if (existing) {
      existing.quantity = (existing.quantity || 1) + quantity;
    } else {
      product.quantity = quantity;
      cart.push(product);
    }
   
    this.saveCart(cart);
    this.showToast(`Đã thêm ${quantity} sản phẩm "${product.name}" vào giỏ hàng!`);
    
    // Cập nhật số lượng trên header
    this.updateHeaderCartCount();
    
    // Đồng bộ với server nếu đã đăng nhập
    if (CartAPI.isAuthenticated()) {
      try {
        await CartAPI.addToCart(product.id, quantity);
      } catch (error) {
        console.error('Lỗi khi đồng bộ giỏ hàng:', error);
      }
    }
  },
  //

  /**
   * Cập nhật số lượng sản phẩm trong giỏ hàng
   * @param {number} productId ID sản phẩm
   * @param {number} quantity Số lượng mới
   */
  async updateCartItem(productId, quantity) {
    // Cập nhật trong localStorage
    const cart = this.getCart();
    const item = cart.find(item => item.id === productId);
    
    if (item) {
      item.quantity = quantity;
      this.saveCart(cart);
      this.showToast('Đã cập nhật giỏ hàng!');
      
      // Cập nhật số lượng trên header
      this.updateHeaderCartCount();
      
      // Đồng bộ với server nếu đã đăng nhập
      if (CartAPI.isAuthenticated()) {
        try {
          await CartAPI.updateCartItem(productId, quantity);
        } catch (error) {
          console.error('Lỗi khi đồng bộ giỏ hàng:', error);
        }
      }
      
      return true;
    }
    
    return false;
  },

  /**
   * Xóa sản phẩm khỏi giỏ hàng
   * @param {number} productId ID sản phẩm
   */
  async removeFromCart(productId) {
    // Xóa khỏi localStorage
    let cart = this.getCart();
    const initialLength = cart.length;
    
    cart = cart.filter(item => item.id !== productId);
    
    if (cart.length !== initialLength) {
      this.saveCart(cart);
      this.showToast('Đã xóa sản phẩm khỏi giỏ hàng!');
      
      // Cập nhật số lượng trên header
      this.updateHeaderCartCount();
      
      // Đồng bộ với server nếu đã đăng nhập
      if (CartAPI.isAuthenticated()) {
        try {
          await CartAPI.removeFromCart(productId);
        } catch (error) {
          console.error('Lỗi khi đồng bộ giỏ hàng:', error);
        }
      }
      
      return true;
    }
    
    return false;
  },

  /**
   * Đồng bộ giỏ hàng từ API với localStorage
   */
  async syncCartFromAPI() {
    if (!CartAPI.isAuthenticated()) {
      return;
    }
    
    try {
      // Lấy giỏ hàng từ API
      const apiCartItems = await CartAPI.getCart();
 
      if (!apiCartItems || apiCartItems.length === 0) {
        return;
      }
      
      // Lấy thông tin chi tiết sản phẩm
      const productsMap = {};
      for (const item of apiCartItems) {
        try {
          const response = await fetch(`http://localhost:3000/product-service/products/${item.productId}`);
          const data = await response.json();
          if (data.product) {
            // Thêm thuộc tính quantity vào sản phẩm
            data.product.quantity = item.quantity;
            productsMap[item.productId] = data.product;
          }
        } catch (error) {
          console.error(`Lỗi khi lấy thông tin sản phẩm ${item.productId}:`, error);
        }
      }
      
      // Lọc ra các sản phẩm hợp lệ
      const validProducts = Object.values(productsMap);
      
      // Cập nhật localStorage
      if (validProducts.length > 0) {
        this.saveCart(validProducts);
      }
    } catch (error) {
      console.error('Lỗi khi đồng bộ giỏ hàng từ API:', error);
    }
  },

  /**
   * Cập nhật số lượng trên biểu tượng giỏ hàng
   */
  updateHeaderCartCount() {
    const cartCountElement = document.getElementById('cart-count');
    
    
    if (cartCountElement) {
      const totalItems = this.getTotalItemsCount();
      
      
      cartCountElement.textContent = totalItems;
      cartCountElement.style.display = totalItems > 0 ? 'inline-block' : 'none';
      
      // Phát sự kiện cartUpdated để cập nhật UI
      
      window.dispatchEvent(new CustomEvent('cartUpdated'));
    } else {
      console.warn("Không tìm thấy element cart-count để cập nhật");
    }
  },

  /**
   * Khởi tạo CartManager
   */
  init() {
    // Đồng bộ giỏ hàng từ API khi người dùng đăng nhập
    if (CartAPI.isAuthenticated()) {
      this.syncCartFromAPI();
    }
    
    // Cập nhật số lượng trên header
    this.updateHeaderCartCount();
    
    // Lắng nghe sự kiện thay đổi giỏ hàng từ tab khác
    window.addEventListener('storage', (event) => {
      if (event.key === 'cart') {
        this.updateHeaderCartCount();
      }
    });
  }
};

// Export module để sử dụng trong các file khác
window.CartManager = CartManager;

// Khởi tạo khi load trang
document.addEventListener('DOMContentLoaded', () => CartManager.init()); 