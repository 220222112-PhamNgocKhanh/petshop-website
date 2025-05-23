// 📁 utils/renderProducts.js

function renderProducts(products, title = "Sản phẩm") {
  const productContainer = document.getElementById("product-container");
  productContainer.innerHTML = "";

  const productsWrapper = document.createElement("div");
  productsWrapper.classList.add("products");

  const header = document.createElement("div");
  header.classList.add("products-header");
  header.innerHTML = `<h1>${title}</h1>`;
  productsWrapper.appendChild(header);

  const mainProducts = document.createElement("div");
  mainProducts.classList.add("main-products");

  if (!products || products.length === 0) {
    mainProducts.innerHTML = "<p>Không có sản phẩm nào phù hợp.</p>";
  } else {
    products.forEach((product) => {
      let badges = "";
      if (product.amount <= 0) {
        badges += `<span class="out-of-stock-badge">Hết hàng</span>`;
      }
      // Lưu lại tên đầy đủ để dùng trong tooltip
      const fullName = product.name;

      const productTag = document.createElement("div");
      productTag.classList.add("product-tags");

      productTag.innerHTML = `
  <div class="product-img">
    <img src="../backend/image/${product.category}/${
        product.image || "default-product.jpg"
      }" 
         alt="${fullName}" 
         loading="lazy" 
         decoding="async"
         onerror="this.onerror=null; this.src='../backend/image/default-product.jpg';">
    <div class="overlay">
      <div class="icon-buttons">
        <div class="icon-wrapper">
          <button class="icon-btn"><i class="fa fa-heart"></i></button>
          <span class="tooltip-text">Yêu thích</span>
        </div>
        <div class="icon-wrapper">
          <button class="icon-btn view-detail-btn" data-id="${
            product.id
          }"><i class="fa fa-search"></i></button>
          <span class="tooltip-text">Xem thêm</span>
        </div>
      </div>
      <button class="buy-btn" data-id="${product.id}">
        <div><a>Buy</a></div>
      </button>
    </div>
    ${badges}
  </div>
  <h1 title="${fullName}">${fullName}</h1>
  <h2>${Number(product.price).toLocaleString("en-US", {
    style: "currency",
    currency: "USD",
  })}</h2>
`;
      mainProducts.appendChild(productTag);
    });
  }

  productsWrapper.appendChild(mainProducts);
  productContainer.appendChild(productsWrapper);

  
// Sau khi DOM được render xong
document.querySelectorAll(".buy-btn").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    // Kiểm tra đăng nhập trước khi thêm vào giỏ hàng
    const isLoggedIn = checkUserLogin();
    
    if (!isLoggedIn) {
      // Lưu URL hiện tại vào localStorage để sau khi đăng nhập có thể quay lại
      localStorage.setItem('redirectAfterLogin', window.location.href);
      
      // Thông báo cho người dùng
      alert("Vui lòng đăng nhập để mua hàng");
      
      // Chuyển hướng đến trang đăng nhập
      window.location.href = "../frontend/login.php";
      return;
    }
    
    // Xử lý tiếp tục nếu đã đăng nhập
    const productId = btn.dataset.id;
    const selectedProduct = products.find((p) => p.id == productId);

    if (selectedProduct && selectedProduct.amount > 0) {
      CartManager.addToCart(selectedProduct, 1);

      // Đợi một chút để đảm bảo giỏ hàng đã được cập nhật
      setTimeout(() => {
        // Kích hoạt cập nhật UI thủ công nếu cần
        if (typeof window.updateCartCount === "function") {
          window.updateCartCount();
        }
      }, 100);
    } else {
      alert("Sản phẩm đã hết hàng");
    }
  });
});

// Thêm hàm kiểm tra đăng nhập
function checkUserLogin() {
  // Kiểm tra xem người dùng đã đăng nhập chưa
  // Đây là một ví dụ - bạn cần điều chỉnh theo cách bạn lưu trữ thông tin đăng nhập
  const user = localStorage.getItem('user') || sessionStorage.getItem('user');
  console.log(user);
  return !!user; // Trả về true nếu có thông tin người dùng, false nếu không
}

}
