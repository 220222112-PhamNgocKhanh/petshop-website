

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
// Xử lý sự kiện tìm kiếm
const searchInput = document.getElementById('search-input');
const searchBtn = document.getElementById('search-btn');

function handleSearch() {
  const keyword = searchInput.value.trim();
  const allCategoryLinks = document.querySelectorAll('.category-list li a');
  allCategoryLinks.forEach(link => link.classList.remove('category-active'));
  if (keyword) {
    localStorage.setItem('searchKeyword', keyword);
    searchProduct(keyword);
  }
}

searchBtn.addEventListener('click', handleSearch);
searchInput.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') {
    handleSearch();
  }
});

document.querySelector('.product-categories').addEventListener('click', (e) => {
  const link = e.target.closest('a');
  console.log('Clearing searchKeyword and navigating to:', link.href);

  if (link) {
    e.preventDefault();
    // Xóa từ khóa tìm kiếm trong localStorage và ô tìm kiếm
    localStorage.removeItem('searchKeyword');
    searchInput.value = ''; // Xóa nội dung trong ô tìm kiếm

    // Điều hướng đến liên kết sau một khoảng thời gian ngắn
    setTimeout(() => {
      window.location.href = link.href;
    }, 100); // delay ngắn để đảm bảo xoá xong
  }
});





// window.addEventListener('DOMContentLoaded', () => {
//   const navType = performance.getEntriesByType("navigation")[0].type;
//   const savedKeyword = localStorage.getItem('searchKeyword');
//   const allCategoryLinks = document.querySelectorAll('.product-categories ul li ul li a');
//   if (navType === 'reload') {
//     // 👉 Trường hợp reload trang
//     console.log("Reload detected");
//     if (savedKeyword) {
//       allCategoryLinks.forEach(link => link.classList.remove('category-active'));
//       searchInput.value = savedKeyword;
//       searchProduct(savedKeyword);
//     } else {
//       searchInput.value = '';
//       showLatestProducts();
//     }
//   } else {
//     //  Trường hợp vào trang mới (nhập URL, chuyển từ trang khác,...)
//     console.log("Fresh visit detected");
//     searchInput.value = '';
//     showLatestProducts();
//     // Nếu muốn xóa luôn keyword đã lưu:
//     localStorage.removeItem('searchKeyword');
//   }
// });
window.addEventListener('DOMContentLoaded', async () => {
  const navType = performance.getEntriesByType("navigation")[0].type;
  const savedCategory = localStorage.getItem('selectedCategory');
  const savedKeyword = localStorage.getItem('searchKeyword');
  const allCategoryLinks = document.querySelectorAll('.category-list li a, .product-categories ul li ul li a');
  const searchInput = document.querySelector('#searchInput');

  if (navType === 'reload') {
    console.log("🔁 Reload detected");

    // 👉 Ưu tiên tìm kiếm nếu có từ khóa tìm kiếm
    if (savedKeyword) {
      allCategoryLinks.forEach(link => link.classList.remove('category-active'));
      if (searchInput) searchInput.value = savedKeyword;
      searchProduct(savedKeyword);
    } else if (savedCategory) {
      // 👉 Nếu không có từ khóa thì xử lý theo danh mục
      showCategory(savedCategory);
      if (searchInput) searchInput.value = '';

      // Reset class active
      allCategoryLinks.forEach(link => link.classList.remove('category-active'));
      const activeLink = Array.from(allCategoryLinks).find(link => link.getAttribute('data-category') === savedCategory);
      if (activeLink) {
        activeLink.classList.add('category-active');
      }
    } else {
      // 👉 Nếu không có gì, hiển thị sản phẩm mới nhất
      if (searchInput) searchInput.value = '';
      showLatestProducts();
    }

  } else {
    // 👉 Truy cập mới
    console.log("🆕 Fresh visit detected");

    allCategoryLinks.forEach(link => link.classList.remove('category-active'));
    if (searchInput) searchInput.value = '';
    showLatestProducts();

    localStorage.removeItem('selectedCategory');
    localStorage.removeItem('searchKeyword');
  }
});


