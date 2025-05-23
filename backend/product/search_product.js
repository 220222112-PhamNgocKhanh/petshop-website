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
function showProducts() {
  fetch('http://localhost:3000/product-service/products')
    .then(res => res.json())
    .then(data => {
      renderProducts(data.products, 'Danh sách sản phẩm');
    })
    .catch(err => {
      console.error('Không thể tải Danh sách sản phẩm:', err);
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
  const allCategoryLinks = document.querySelectorAll('.category-list li a, .product-categories ul li ul li a');
allCategoryLinks.forEach(link => link.classList.remove('category-active'));

// Thêm active cho danh mục phù hợp
allCategoryLinks.forEach(categoryLink => {
  const linkCategory = categoryLink.getAttribute('data-category');
  if (linkCategory && (
      linkCategory.toLowerCase() === selectedCategory.toLowerCase() || 
      linkCategory.includes(selectedCategory) || 
      selectedCategory.includes(linkCategory)
  )) {
    categoryLink.classList.add('category-active');
  }
});
  
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
    showProducts();
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
  const forceSelectCategory = localStorage.getItem('forceSelectCategory');
  const allCategoryLinks = document.querySelectorAll('.category-list li a, .product-categories ul li ul li a');
    // Kiểm tra xem có tham số URL không
  const urlParams = new URLSearchParams(window.location.search);
  const urlCategory = urlParams.get('category');
  const resetParam = urlParams.get('reset');
  
  // Nếu có tham số reset, xóa tất cả thông tin trong localStorage
  if (resetParam === 'true') {
    console.log("🧹 Reset parameter detected, clearing localStorage data");
    localStorage.removeItem('selectedCategory');
    localStorage.removeItem('searchKeyword');
    localStorage.removeItem('forceSelectCategory');
  }
  // Nếu có tham số category trong URL, ưu tiên sử dụng nó
  else if (urlCategory) {
    console.log("📌 URL category parameter detected:", urlCategory);
    // Xóa danh mục đã lưu và các tùy chọn khác trong localStorage
    localStorage.removeItem('selectedCategory');
    localStorage.removeItem('searchKeyword');
    localStorage.removeItem('forceSelectCategory');
  } else {
    // Xóa cờ forceSelectCategory sau khi đã sử dụng
    if (forceSelectCategory) {
      localStorage.removeItem('forceSelectCategory');
    }
  }
  
  // Xử lý cả trường hợp reload và truy cập từ trang khác có savedCategory
  if (urlCategory || navType === 'reload' || savedCategory) {
    if (urlCategory) {
      console.log("🔗 Using URL category parameter:", urlCategory);
    } else if (navType === 'reload') {
      console.log("🔁 Reload detected");
    } else {
      console.log("🔄 Navigation with saved category detected");
    }
    
    // Ưu tiên sử dụng tham số URL nếu có
    const categoryToUse = urlCategory || savedCategory;
    
    // Khôi phục giá trị cho dropdown danh mục và ô tìm kiếm
    if (categoryToUse && categorySelect) {
      // Tìm option chính xác nếu có
      const exactOption = Array.from(categorySelect.options).find(
        option => option.value === categoryToUse
      );
      
      if (exactOption) {
        categorySelect.value = categoryToUse;
      } else {
        categorySelect.value = 'all';
      }
    }
      // Kiểm tra tham số id (nếu có)
    const productId = urlParams.get('id');
    if (productId) {
      console.log("🆔 Product ID parameter detected:", productId);
      // Nếu có ID sản phẩm, hiển thị sản phẩm đó thay vì danh sách
      // Không thay đổi localStorage
      if (typeof showProductDetail === 'function') {
        showProductDetail(productId);
        return; // Thoát khỏi hàm vì chúng ta chỉ hiển thị chi tiết sản phẩm
      }
    }
    
    // Chuyển đổi tham số URL category thành tên danh mục nếu cần
    let categoryToShow = urlCategory;
    if (categoryToShow) {
      // Ánh xạ các giá trị đặc biệt từ URL thành tên danh mục
      const categoryMapping = {
        'dog-food': 'Dog Food',
        'cat-food': 'Cat Food',
        'toys': 'Collars',  // Ví dụ
        'accessories': 'Odor Control',
        'health': 'Multivitamins',
      };
      
      if (categoryMapping[categoryToShow]) {
        categoryToShow = categoryMapping[categoryToShow];
      }
    }
    
    if (searchInput && savedKeyword && !urlCategory) {
      searchInput.value = savedKeyword;
    } else if (searchInput) {
      searchInput.value = '';
    }
    
    // Xử lý hiển thị dựa trên thông tin đã lưu hoặc tham số URL
    if (categoryToShow) {
      // Hiển thị danh mục từ URL
      showCategory(categoryToShow);
      
      // Cập nhật giao diện
      allCategoryLinks.forEach(link => link.classList.remove('category-active'));
      const activeLink = Array.from(allCategoryLinks).find(
        link => link.getAttribute('data-category') === categoryToShow
      );
      if (activeLink) {
        activeLink.classList.add('category-active');
      }
    } else if (savedKeyword && savedCategory && savedCategory !== 'all') {
      // Tìm kiếm với từ khóa trong danh mục đã lưu
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
      // Chỉ hiển thị danh mục đã lưu
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
      // Hiển thị tất cả sản phẩm
      if (searchInput) searchInput.value = '';
      if (categorySelect) categorySelect.value = 'all';
      showProducts();
    }
  } else {
    // Truy cập mới
    console.log("🆕 Fresh visit detected");
    
    if (searchInput) searchInput.value = '';
    if (categorySelect) categorySelect.value = 'all';
    allCategoryLinks.forEach(link => link.classList.remove('category-active'));
    showProducts();
    
    localStorage.removeItem('selectedCategory');
    localStorage.removeItem('searchKeyword');
  }
});


