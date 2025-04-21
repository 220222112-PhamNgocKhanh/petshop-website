function showCategory(categoryName) {
  fetch(`http://localhost:3000/product-service/products/search/${categoryName}`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Không tìm thấy sản phẩm');
      }
      return response.json();
    })
    .then(data => {
      const products = data.products;

      const productContainer = document.getElementById('product-container');
      productContainer.innerHTML = ''; // Xóa nội dung cũ

      // Tạo khung chính
      const productsWrapper = document.createElement('div');
      productsWrapper.classList.add('products');

      // Tiêu đề danh mục
      const header = document.createElement('div');
      header.classList.add('products-header');
      header.innerHTML = `<h1>${categoryName}</h1>`;
      productsWrapper.appendChild(header);

      // Vùng chứa sản phẩm
      const mainProducts = document.createElement('div');
      mainProducts.classList.add('main-products');

      // Duyệt danh sách sản phẩm
      products.forEach(product => {
        const productTag = document.createElement('div');
        productTag.classList.add('product-tags');

        productTag.innerHTML = `
  <div class="product-img">
    <img src="../backend/image/${categoryName}/${product.image || 'default-product.jpg'}" alt="${product.name}">
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

      // Thêm vào khung chính
      productsWrapper.appendChild(mainProducts);

      // Gắn toàn bộ vào container
      productContainer.appendChild(productsWrapper);
    })
    .catch(error => {
      console.error('Lỗi khi tải danh mục:', error);
      alert('Không thể tải sản phẩm từ danh mục!');
    });
}
function saveCategoryAndShow(categoryName) {
  localStorage.setItem('selectedCategory', categoryName);
  showCategory(categoryName);
  // Xoá class 'category-active' khỏi tất cả các mục
  const allCategoryLinks = document.querySelectorAll('.product-categories ul li ul li a');
  allCategoryLinks.forEach(link => link.classList.remove('category-active'));

  // Tìm và gán class cho mục vừa click
  const clickedLink = Array.from(allCategoryLinks).find(link => link.textContent.trim() === categoryName);
  if (clickedLink) {
    clickedLink.classList.add('category-active');
  }
}
window.addEventListener('DOMContentLoaded', () => {
  const savedCategory = localStorage.getItem('selectedCategory');
  if (savedCategory) {
    showCategory(savedCategory);
     // Xoá class khỏi các mục khác
     const allCategoryLinks = document.querySelectorAll('.product-categories ul li ul li a');
     allCategoryLinks.forEach(link => link.classList.remove('category-active'));
 
     // Gán lại class cho mục đã chọn
     const activeLink = Array.from(allCategoryLinks).find(link => link.textContent.trim() === savedCategory);
     if (activeLink) {
       activeLink.classList.add('category-active');
     }
  }
});

