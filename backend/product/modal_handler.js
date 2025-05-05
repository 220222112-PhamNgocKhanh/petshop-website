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
      <div id="modal-body-content">
        <div class="zoom-container">
          <img class="zoom-image product-image" 
               src="../backend/image/${data.category}/${data.image || 'default-product.jpg'}" 
               alt="${data.name}">
        </div>
        <div class="product-info">
          <h2>${data.name}</h2>
          <p><strong>Giá:</strong> ${Number(data.price).toLocaleString('en-US', { style: 'currency', currency: 'USD' })}</p>
          <p><strong>Tình trạng:</strong> ${data.amount > 0 ? `Còn ${data.amount} hàng` : 'Hết hàng'}</p>
          <p><strong>Danh mục:</strong> ${data.category}</p>
          <p><strong>Mô tả:</strong> ${data.description || 'Không có mô tả.'}</p>
      
          ${data.amount > 0 ? `
            <div class="quantity-group">
              <label for="quantity">Số lượng:</label>
              <input type="number" id="quantity" min="1" max="${data.amount}" value="1">
              <button id="addToCartBtn">Buy</button>
            </div>
          ` : ''}
        </div>
      </div>
      `;
      
      const zoomContainer = document.querySelector('.zoom-container');
      const zoomImage = document.querySelector('.zoom-image');
      
      zoomContainer.addEventListener('mousemove', (e) => {
        const { left, top, width, height } = zoomContainer.getBoundingClientRect();
        const x = ((e.pageX - left - window.scrollX) / width) * 100;
        const y = ((e.pageY - top - window.scrollY) / height) * 100;
        zoomImage.style.transformOrigin = `${x}% ${y}%`;
        zoomImage.style.transform = 'scale(2)'; // hoặc scale(1.5) tùy mức phóng bạn muốn
      });
      
      zoomContainer.addEventListener('mouseleave', () => {
        zoomImage.style.transform = 'scale(1)';
        zoomImage.style.transformOrigin = 'center center';
      });
           
      document.getElementById("productModal").style.display = "block";
      document.getElementById("addToCartBtn")?.addEventListener("click", () => {
        const quantity = parseInt(document.getElementById("quantity").value);
        addToCart(data, quantity);
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
