<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách sản phẩm</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="product-container" class="product-container">
  <!-- Các sản phẩm sẽ được hiển thị ở đây -->
</div>

<script src="product_detail.js"></script>
<script src="product_detail_all.js"></script>

<script>
  function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  const productName = getQueryParam("name");
  const categoryId = getQueryParam("category_id");

  if (productName && isNaN(productName)) {
    // Nếu là chuỗi, gọi theo tên sản phẩm
    loadProductDetail(productName);
  } else if (categoryId && !isNaN(categoryId)) {
    // Nếu là số, gọi theo ID danh mục
    loadProductByCategory(categoryId);
  } else {
    // Không có tham số hợp lệ
    document.getElementById("product-container").innerHTML = "<p>Không có sản phẩm nào được chọn.</p>";
  }
</script>

</body>
</html>
