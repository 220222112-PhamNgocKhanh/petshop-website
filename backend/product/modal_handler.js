document.addEventListener("click", async (e) => {
  if (e.target.closest(".view-detail-btn")) {
    const productId = e.target
      .closest(".view-detail-btn")
      .getAttribute("data-id");

    try {
      const res = await fetch(
        `http://localhost:3000/product-service/products/${productId}`
      );
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
              ${data.amount > 0 ? `Còn ${data.amount} hàng` : 'Hết hàng'}
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
      <style>
        .product-modal-content {
          padding: 20px;
        }
        .product-modal-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 30px;
          max-width: 1000px;
          margin: 0 auto;
        }
        .zoom-container {
          position: relative;
          overflow: hidden;
          border-radius: 8px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .zoom-image {
          width: 100%;
          height: auto;
          transition: transform 0.3s ease;
          display: block;
        }
        .product-info {
          padding: 20px;
        }
        .product-title {
          font-size: 24px;
          margin-bottom: 15px;
          color: #333;
        }
        .product-price {
          font-size: 28px;
          font-weight: bold;
          color: #e44d26;
          margin-bottom: 15px;
        }
        .product-status {
          display: inline-block;
          padding: 6px 12px;
          border-radius: 4px;
          margin-bottom: 15px;
          font-weight: 500;
        }
        .in-stock {
          background-color: #e8f5e9;
          color: #2e7d32;
        }
        .out-of-stock {
          background-color: #ffebee;
          color: #c62828;
        }
        .product-category {
          margin-bottom: 20px;
        }
        .category-label {
          font-weight: 500;
          color: #666;
        }
        .category-value {
          color: #333;
          margin-left: 8px;
        }
        .product-description {
          margin-bottom: 25px;
        }
        .product-description h3 {
          font-size: 18px;
          margin-bottom: 10px;
          color: #333;
        }
        .product-description p {
          color: #666;
          line-height: 1.6;
        }
        .quantity-group {
          margin-top: 20px;
        }
        .quantity-controls {
          display: flex;
          align-items: center;
          margin: 10px 0;
        }
        .quantity-btn {
          width: 36px;
          height: 36px;
          border: 1px solid #ddd;
          background: #f8f8f8;
          font-size: 18px;
          cursor: pointer;
          transition: all 0.3s ease;
        }
        .quantity-btn:hover {
          background: #e0e0e0;
        }
        #quantity {
          width: 60px;
          height: 36px;
          text-align: center;
          border: 1px solid #ddd;
          margin: 0 5px;
        }
        .add-to-cart-btn {
          width: 100%;
          padding: 12px;
          background-color: #4CAF50;
          color: white;
          border: none;
          border-radius: 4px;
          font-size: 16px;
          cursor: pointer;
          transition: background-color 0.3s ease;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
        }
        .add-to-cart-btn:hover {
          background-color: #45a049;
        }
        @media (max-width: 768px) {
          .product-modal-grid {
            grid-template-columns: 1fr;
          }
        }
      </style>
      `;
      
      const zoomContainer = document.querySelector('.zoom-container');
      const zoomImage = document.querySelector('.zoom-image');
      
      zoomContainer.addEventListener('mousemove', (e) => {
        const { left, top, width, height } = zoomContainer.getBoundingClientRect();
        const x = ((e.pageX - left - window.scrollX) / width) * 100;
        const y = ((e.pageY - top - window.scrollY) / height) * 100;
        zoomImage.style.transformOrigin = `${x}% ${y}%`;
        zoomImage.style.transform = 'scale(2)';
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
        const quantity = parseInt(document.getElementById("quantity").value);
        CartManager.addToCart(data, quantity);
        // Đợi một chút để đảm bảo giỏ hàng đã được cập nhật
        setTimeout(() => {
          // Kích hoạt cập nhật UI thủ công nếu cần
          if (typeof window.updateCartCount === "function") {
            window.updateCartCount();
          }
        }, 100);
        
      });
    } catch (error) {
      console.error("Lỗi khi tải dữ liệu sản phẩm:", error);
    }
  }
});

// Đóng modal
document.querySelector(".close").onclick = () => {
  document.getElementById("productModal").style.display = "none";
};

window.onclick = (e) => {
  const modal = document.getElementById("productModal");
  if (e.target === modal) {
    modal.style.display = "none";
  }
};
