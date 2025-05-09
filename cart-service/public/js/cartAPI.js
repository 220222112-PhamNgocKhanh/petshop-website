/**
 * CartAPI: Module xử lý giao tiếp với Cart Service API
 */
const CartAPI = {
  /**
   * API Base URL
   */
  baseUrl: 'http://localhost:3000/cart-service/cart',

  /**
   * Lấy token xác thực từ localStorage
   * @returns {string|null} Token xác thực nếu đã đăng nhập
   */
  getAuthToken() {
    return localStorage.getItem('token');
  },

  /**
   * Lấy ID người dùng từ token
   * @returns {number|null} ID người dùng nếu đã đăng nhập
   */
  getUserId() {
    const token = this.getAuthToken();
   
    if (!token) return null;
    
    try {
      const payload = JSON.parse(atob(token.split('.')[1]));

      return payload.user_id;  // Đảm bảo truy cập đúng thuộc tính user_id
      
    } catch (error) {
      console.error('Lỗi khi giải mã token:', error);
      return null;
    }
  },

  /**
   * Kiểm tra người dùng đã đăng nhập chưa
   * @returns {boolean} Trạng thái đăng nhập
   */
  isAuthenticated() {
    return !!this.getAuthToken();
  },

  /**
   * Lấy giỏ hàng từ API
   * @returns {Promise<Array>} Danh sách các mặt hàng trong giỏ
   */
  async getCart() {
    if (!this.isAuthenticated()) {
      return Promise.resolve([]);
    }

    const userId = this.getUserId();
    if (!userId) {
      return Promise.resolve([]);
    }

    try {
      const response = await fetch(`${this.baseUrl}/${userId}`, {
        headers: {
          'Authorization': `Bearer ${this.getAuthToken()}`
        }
      });
      
      if (!response.ok) {
        throw new Error('Không thể tải giỏ hàng');
      }
      
      const data = await response.json();
     
      return data || [];
    } catch (error) {
      console.error('Lỗi khi lấy giỏ hàng:', error);
      return [];
    }
  },

  /**
   * Thêm sản phẩm vào giỏ hàng
   * @param {number} productId ID sản phẩm
   * @param {number} quantity Số lượng
   * @returns {Promise<Object>} Kết quả từ API
   */
  async addToCart(productId, quantity = 1) {
    if (!this.isAuthenticated()) {
      return Promise.resolve(null);
    }

    const userId = this.getUserId();
   
    if (!userId) {
      return Promise.resolve(null);
    }

    try {
      const response = await fetch(`${this.baseUrl}/${userId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${this.getAuthToken()}`
        },
        body: JSON.stringify({
          productId,
          quantity
        })
      });
      
      if (!response.ok) {
        throw new Error('Không thể thêm vào giỏ hàng');
      }
      
      return await response.json();
    } catch (error) {
      console.error('Lỗi khi thêm vào giỏ hàng:', error);
      return null;
    }
  },

  /**
   * Cập nhật số lượng sản phẩm trong giỏ hàng
   * @param {number} productId ID sản phẩm
   * @param {number} quantity Số lượng mới
   * @returns {Promise<Object>} Kết quả từ API
   */
  async updateCartItem(productId, quantity) {
    if (!this.isAuthenticated()) {
      return Promise.resolve(null);
    }

    const userId = this.getUserId();
    if (!userId) {
      return Promise.resolve(null);
    }

    try {
      const response = await fetch(`${this.baseUrl}/${userId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${this.getAuthToken()}`
        },
        body: JSON.stringify({
          productId,
          quantity
        })
      });
      
      if (!response.ok) {
        throw new Error('Không thể cập nhật giỏ hàng');
      }
      
      return await response.json();
    } catch (error) {
      console.error('Lỗi khi cập nhật giỏ hàng:', error);
      return null;
    }
  },

  /**
   * Xóa sản phẩm khỏi giỏ hàng
   * @param {number} productId ID sản phẩm
   * @returns {Promise<Object>} Kết quả từ API
   */
  async removeFromCart(productId) {
    if (!this.isAuthenticated()) {
      return Promise.resolve(null);
    }

    const userId = this.getUserId();
    if (!userId) {
      return Promise.resolve(null);
    }

    try {
      const response = await fetch(`${this.baseUrl}/${userId}/${productId}`, {
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${this.getAuthToken()}`
        }
      });
      
      if (!response.ok) {
        throw new Error('Không thể xóa sản phẩm khỏi giỏ hàng');
      }
      
      return await response.json();
    } catch (error) {
      console.error('Lỗi khi xóa sản phẩm khỏi giỏ hàng:', error);
      return null;
    }
  },

  /**
   * Lấy tổng số lượng sản phẩm trong giỏ hàng trực tiếp từ API
   * @returns {Promise<number>} Tổng số lượng sản phẩm
   */
  async getCartCount() {
    if (!this.isAuthenticated()) {
      return Promise.resolve(0);
    }

    const userId = this.getUserId();
    if (!userId) {
      return Promise.resolve(0);
    }

    try {
      const items = await this.getCart();
     
      return items.reduce((total, item) => total + (item.quantity || 1), 0);
    } catch (error) {
      console.error('Lỗi khi lấy số lượng giỏ hàng:', error);
      return 0;
    }
  }
};

// Export module để sử dụng trong các file khác
window.CartAPI = CartAPI; 