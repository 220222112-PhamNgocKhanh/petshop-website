function searchProduct(keyword) {
    fetch(`http://localhost:3000/product-service/products/searchbyname/${encodeURIComponent(keyword)}`)
      .then(response => {
        // if (!response.ok) throw new Error('Không tìm thấy sản phẩm');
        return response.json();
      })
      .then(data => {
        const products = data.products;
  
        const productContainer = document.getElementById('product-container');
        productContainer.innerHTML = '';
  
        const productsWrapper = document.createElement('div');
        productsWrapper.classList.add('products');
  
        const header = document.createElement('div');
        header.classList.add('products-header');
        header.innerHTML = `<h1>Kết quả tìm kiếm cho: "${keyword}"</h1>`;
        productsWrapper.appendChild(header);
  
        const mainProducts = document.createElement('div');
        mainProducts.classList.add('main-products');
     
        if (data.message == 'Không tìm thấy sản phẩm nào phù hợp') {
          mainProducts.innerHTML = '<p>Không có sản phẩm nào phù hợp.</p>';
        } else {
          products.forEach(product => {
            const productTag = document.createElement('div');
            productTag.classList.add('product-tags');
  
            productTag.innerHTML = `
              <div class="product-img">
                <img src="../backend/image/${product.subcategory}/${product.image || 'default-product.jpg'}" alt="${product.name}">
                <div class="overlay">
                  <div class="icon-buttons">
                    <div class="icon-wrapper">
                      <button class="icon-btn"><i class="fa fa-heart"></i></button>
                      <span class="tooltip-text">Yêu thích</span>
                    </div>
                    <div class="icon-wrapper">
                      <button class="icon-btn"><i class="fa fa-search"></i></button>
                      <span class="tooltip-text">Xem thêm</span>
                    </div>
                  </div>
                  <button class="buy-btn">
                    <div><a>MUA HÀNG</a></div>
                  </button>
                </div>
              </div>
              <h1>${product.name}</h1>
              <h2>${Number(product.price).toLocaleString('vi-VN')} <span>₫</span></h2>
            `;
            mainProducts.appendChild(productTag);
          });
        }
  
        productsWrapper.appendChild(mainProducts);
        productContainer.appendChild(productsWrapper);
      })
      .catch(error => {
        console.error('Lỗi tìm kiếm:', error);
        alert('Không thể tìm thấy sản phẩm!');
      });
  }
  const searchInput = document.getElementById('search-input');
const searchBtn = document.getElementById('search-btn');

function handleSearch() {
  const keyword = searchInput.value.trim();
  if (keyword) {
    localStorage.setItem('searchKeyword', keyword);
    searchProduct(keyword);
  }
}

searchBtn.addEventListener('click', handleSearch);

// ✅ Bắt sự kiện Enter trên input
searchInput.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') {
    handleSearch();
  }
});
  window.addEventListener('DOMContentLoaded', () => {
    const savedKeyword = localStorage.getItem('searchKeyword');
    if (savedKeyword) {
      document.getElementById('search-input').value = savedKeyword; // Set lại ô input
      searchProduct(savedKeyword);
    }
  });
  
  
  