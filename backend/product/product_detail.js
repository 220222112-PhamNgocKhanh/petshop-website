
function showCategory(categoryName) {
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


const categoryContainer = document.querySelector('.category-list'); // Thay đổi selector cho đúng với HTML

if (categoryContainer) {
  categoryContainer.addEventListener('click', (e) => {
    const link = e.target.closest('a'); // Tìm link gần nhất (nếu có)

    if (!link) return; // Nếu không phải link, thì thoát

    const category = link.dataset.category; // Lấy danh mục từ thuộc tính data-category
    if (category) {
      e.preventDefault(); // Ngăn trang load lại

      // Xóa từ khóa tìm kiếm cũ trong localStorage (nếu có)
      localStorage.removeItem('searchKeyword');
      
      // Nếu có ô tìm kiếm, xóa nội dung ô tìm kiếm
      const searchInput = document.querySelector('#searchInput');
      if (searchInput) searchInput.value = '';

      // Gọi hàm saveCategoryAndShow để hiển thị sản phẩm theo danh mục
      saveCategoryAndShow(category);
    }
  });
}






