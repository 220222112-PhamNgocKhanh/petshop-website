
function showCategory(categoryName) {
  console.log(`Showing category: ${categoryName}`);
  
  // Cập nhật dropdown category nếu có
  if (document.getElementById('categorySelect')) {
    const categorySelect = document.getElementById('categorySelect');
    // Tìm option chính xác nếu có
    const exactOption = Array.from(categorySelect.options).find(
      option => option.value === categoryName
    );
    
    if (exactOption) {
      console.log(`Setting dropdown to: ${categoryName}`);
      categorySelect.value = categoryName;
    } else {
      console.log(`Category ${categoryName} not found in dropdown, setting to 'all'`);
      categorySelect.value = 'all';
    }
  }
  
  fetch(`http://localhost:3000/product-service/products/search/${encodeURIComponent(categoryName)}`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Không tìm thấy sản phẩm');
      }
      return response.json();
    })
    .then(data => {
      renderProducts(data.products, `"${categoryName}"`);
    })
    .catch(error => {
      console.error('Lỗi khi tải danh mục:', error);
      alert('Không thể tải sản phẩm từ danh mục!');
    });
}
function saveCategoryAndShow(categoryName) {
  localStorage.removeItem('searchKeyword');
  localStorage.setItem('selectedCategory', categoryName);

  showCategory(categoryName);

  // Cập nhật giao diện
  const allCategoryLinks = document.querySelectorAll('.category-list li a');
  allCategoryLinks.forEach(link => link.classList.remove('category-active'));

  const clickedLink = Array.from(allCategoryLinks).find(link => link.getAttribute('data-category') === categoryName);
  if (clickedLink) {
    clickedLink.classList.add('category-active');
  }
}


const categoryWrapper = document.querySelector('.category-wrapper'); // đúng vùng chứa tất cả danh mục

if (categoryWrapper) {
  categoryWrapper.addEventListener('click', (e) => {
    const link = e.target.closest('a'); // Tìm phần tử <a> gần nhất

    if (!link) return;

    const category = link.dataset.category; // lấy data-category
    if (category) {
      e.preventDefault(); // Ngăn load lại trang

      // Xóa từ khóa tìm kiếm cũ trong localStorage (nếu có)
      localStorage.removeItem('searchKeyword');

      // Nếu có ô tìm kiếm, xóa nội dung ô tìm kiếm
      const searchInput = document.querySelector('#searchInput');
      if (searchInput) searchInput.value = '';

      // Gọi hàm để xử lý danh mục
      saveCategoryAndShow(category);
    }
  });
}







