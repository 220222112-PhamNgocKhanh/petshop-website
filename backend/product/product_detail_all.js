function loadProductByCategory(category_id) {

    fetch(`http://localhost:3000/product-service/products/category/${category_id}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Không tìm thấy sản phẩm');
        }
        return response.json();
      })
      .then(data => {
        console.log(data);
  
        // Lấy mảng sản phẩm từ trường "products"
        const products = data.products;
        
        // Kiểm tra nếu mảng không rỗng
        if (Array.isArray(products) && products.length > 0) {
          // Lấy container để hiển thị sản phẩm
          const productContainer = document.getElementById('product-container');
          productContainer.innerHTML = '';  // Xóa nội dung cũ nếu có
  
          // Duyệt qua tất cả các sản phẩm trong mảng
          products.forEach(product => {
            const productElement = document.createElement('div');
            productElement.classList.add('product');
  
            // Tạo nội dung cho mỗi sản phẩm
            productElement.innerHTML = `
              <div class="product-image">
                <img src="../image/${product.image || 'default-product.jpg'}" alt="${product.name}">
              </div>
              <div class="product-info">
                <h2 class="product-name">${product.name}</h2>
                <p class="product-price">Giá: ${product.price.toLocaleString('vi-VN')}₫</p>
                <p class="product-description">${product.description}</p>
                <button class="buy-button">Mua ngay</button>
              </div>
            `;
  
            // Thêm phần tử sản phẩm vào container
            productContainer.appendChild(productElement);
          });
        } else {
          alert('Không tìm thấy sản phẩm phù hợp');
        }
      })
      .catch(error => {
        console.error('Lỗi khi lấy sản phẩm:', error);
        alert('Không thể tải sản phẩm!');
      });
  }
  