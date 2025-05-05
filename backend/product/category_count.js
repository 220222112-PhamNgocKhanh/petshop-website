// Gọi API để lấy dữ liệu thống kê số lượng sản phẩm theo category
fetch('http://localhost:3000/product-service/products/count-by-category')
  .then(response => response.json())
  .then(data => {
    updateCategoryCounts(data.counts);
  })
  .catch(error => {
    console.error('Lỗi khi tải số lượng sản phẩm theo category:', error);
  });

// Hàm cập nhật giao diện
function updateCategoryCounts(counts) {
  counts.forEach(({ category, count }) => {
    // Tìm thẻ <a> chứa tên category
    const categoryLink = Array.from(document.querySelectorAll('.product-categories a'))
      .find(link => link.textContent.trim() === category);

    if (categoryLink) {
      const span = document.createElement('span');
      span.style.fontSize = '12px';
      span.style.color = '#888';
      span.style.marginLeft = '4px';
      span.textContent = `(${count})`;
      categoryLink.appendChild(span);
    }
  });
}
