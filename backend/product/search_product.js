// Trong searchProduct
function searchProduct(keyword) {
  fetch(`http://localhost:3000/product-service/products/searchbyname/${keyword}`)
    .then(response => response.json())
    .then(data => {
      renderProducts(data.products, `Kết quả tìm kiếm cho: "${keyword}"`);
    })
    .catch(error => {
      console.error('Lỗi tìm kiếm:', error);
      alert('Không thể tìm thấy sản phẩm!');
    });
}

// Trong showLatestProducts
function showLatestProducts() {
  fetch('http://localhost:3000/product-service/products/latest')
    .then(res => res.json())
    .then(data => {
      renderProducts(data.products, 'Sản phẩm mới nhất');
    })
    .catch(err => {
      console.error('Không thể tải sản phẩm mới nhất:', err);
    });
}

function searchInCategory(keyword, category) {
  fetch(`http://localhost:3000/product-service/products/search-category/${category}/${keyword}`)
    .then(res => res.json())
    .then(data => {
      renderProducts(data.products, `Kết quả tìm kiếm cho: "${keyword}" trong danh mục: "${category}"`);
    })
    .catch(error => {
      console.error('Lỗi tìm kiếm trong danh mục:', error);
      alert('Không thể tìm thấy sản phẩm trong danh mục này!');
    });
}

// Xử lý sự kiện tìm kiếm
const searchInput = document.getElementById('search-input');
const searchBtn = document.getElementById('search-btn');
const categorySelect = document.getElementById('categorySelect');

function handleSearch() {
  const selectedCategory = categorySelect.value.trim();
  console.log('Selected category:', selectedCategory);
  const keyword = searchInput.value.trim();
  console.log('Keyword:', keyword);
  const allCategoryLinks = document.querySelectorAll('.category-list li a');
  allCategoryLinks.forEach(link => link.classList.remove('category-active'));
  
  // Nếu có từ khóa tìm kiếm
  if (keyword && selectedCategory == 'all') {
    // Tìm kiếm toàn bộ
    localStorage.setItem('searchKeyword', keyword);
    localStorage.removeItem('selectedCategory');
    searchProduct(keyword);
  }
  else if (keyword && selectedCategory != 'all') {
    // Tìm kiếm trong danh mục đã chọn
    localStorage.setItem('searchKeyword', keyword);
    localStorage.setItem('selectedCategory', selectedCategory);
    searchInCategory(keyword, selectedCategory);
  }
  else if (!keyword && selectedCategory != 'all') {
    // Chỉ hiển thị danh mục được chọn
    localStorage.removeItem('searchKeyword');
    localStorage.setItem('selectedCategory', selectedCategory);
    showCategory(selectedCategory);
    
    // Thêm active cho danh mục trong sidebar nếu có
    const activeLink = Array.from(allCategoryLinks).find(
      link => link.getAttribute('data-category') === selectedCategory
    );
    if (activeLink) {
      activeLink.classList.add('category-active');
    }
  }
  else {
    // Không có từ khóa và không có danh mục, hiển thị sản phẩm mới nhất
    localStorage.removeItem('searchKeyword');
    localStorage.removeItem('selectedCategory');
    showLatestProducts();
  }
}

searchBtn.addEventListener('click', handleSearch);
searchInput.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') {
    handleSearch();
  }
});

// Thêm event listener cho dropdown category
categorySelect.addEventListener('change', function() {
  console.log('Category changed to:', this.value);
  handleSearch();
});

document.querySelector('.product-categories').addEventListener('click', (e) => {
  const link = e.target.closest('a');
  
  if (link) {
    e.preventDefault();
    const category = link.getAttribute('data-category');
    
    if (category) {
      // Lưu danh mục đã chọn
      localStorage.setItem('selectedCategory', category);
      
      // Xóa từ khóa tìm kiếm
      localStorage.removeItem('searchKeyword');
      searchInput.value = '';
      
      // Cập nhật dropdown để khớp với danh mục đã chọn
      if (categorySelect) {
        // Tìm option chính xác nếu có
        const exactOption = Array.from(categorySelect.options).find(
          option => option.value === category
        );
        
        if (exactOption) {
          categorySelect.value = category;
        } else {
          categorySelect.value = 'all';
        }
      }
      
      // Hiển thị sản phẩm theo danh mục
      showCategory(category);
      
      // Cập nhật giao diện
      const allCategoryLinks = document.querySelectorAll('.category-list li a, .product-categories ul li ul li a');
      allCategoryLinks.forEach(link => link.classList.remove('category-active'));
      
      // Thêm class active cho danh mục đã chọn
      link.classList.add('category-active');
    }
  }
});

window.addEventListener('DOMContentLoaded', async () => {
  const navType = performance.getEntriesByType("navigation")[0].type;
  const savedCategory = localStorage.getItem('selectedCategory');
  const savedKeyword = localStorage.getItem('searchKeyword');
  const allCategoryLinks = document.querySelectorAll('.category-list li a, .product-categories ul li ul li a');
  
  if (navType === 'reload') {
    console.log("🔁 Reload detected");
    
    // Khôi phục giá trị cho dropdown danh mục và ô tìm kiếm
    if (savedCategory && categorySelect) {
      // Tìm option chính xác nếu có
      const exactOption = Array.from(categorySelect.options).find(
        option => option.value === savedCategory
      );
      
      if (exactOption) {
        categorySelect.value = savedCategory;
      } else {
        categorySelect.value = 'all';
      }
    }
    
    if (searchInput && savedKeyword) {
      searchInput.value = savedKeyword;
    }
    
    // Xử lý hiển thị dựa trên thông tin đã lưu
    if (savedKeyword && savedCategory && savedCategory !== 'all') {
      // Tìm kiếm với từ khóa trong danh mục đã chọn
      searchInCategory(savedKeyword, savedCategory);
      
      // Cập nhật giao diện
      allCategoryLinks.forEach(link => link.classList.remove('category-active'));
      const activeLink = Array.from(allCategoryLinks).find(
        link => link.getAttribute('data-category') === savedCategory
      );
      if (activeLink) {
        activeLink.classList.add('category-active');
      }
    } else if (savedKeyword) {
      // Chỉ tìm kiếm với từ khóa
      searchProduct(savedKeyword);
    } else if (savedCategory && savedCategory !== 'all') {
      // Chỉ hiển thị danh mục
      showCategory(savedCategory);
      
      // Cập nhật giao diện
      allCategoryLinks.forEach(link => link.classList.remove('category-active'));
      const activeLink = Array.from(allCategoryLinks).find(
        link => link.getAttribute('data-category') === savedCategory
      );
      if (activeLink) {
        activeLink.classList.add('category-active');
      }
    } else {
      // Hiển thị sản phẩm mới nhất
      if (searchInput) searchInput.value = '';
      if (categorySelect) categorySelect.value = 'all';
      showLatestProducts();
    }
  } else {
    // Truy cập mới
    console.log("🆕 Fresh visit detected");
    
    if (searchInput) searchInput.value = '';
    if (categorySelect) categorySelect.value = 'all';
    allCategoryLinks.forEach(link => link.classList.remove('category-active'));
    showLatestProducts();
    
    localStorage.removeItem('selectedCategory');
    localStorage.removeItem('searchKeyword');
  }
});


