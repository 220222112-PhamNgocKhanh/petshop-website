<!DOCTYPE html>
<html>

<head>
  <title>Orders | PetGuide</title>
  <meta charset="iso-8859-1">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/header.css" rel="stylesheet" type="text/css">
  <!--[if IE 6]><link href="css/ie6.css" rel="stylesheet" type="text/css"><![endif]-->
  <!--[if IE 7]><link href="css/ie7.css" rel="stylesheet" type="text/css"><![endif]-->
  <style>
    .orders-container {
      padding: 20px;
      background: #fff;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .order-tabs {
      display: flex;
      border-bottom: 1px solid #ddd;
      margin-bottom: 20px;
    }

    .order-tab {
      padding: 10px 20px;
      cursor: pointer;
      border: 1px solid transparent;
      border-bottom: none;
      margin-right: 5px;
      border-radius: 5px 5px 0 0;
    }

    .order-tab.active {
      background: #5c9d7e;
      color: white;
      border-color: #5c9d7e;
    }

    .order-item {
      border: 1px solid #eee;
      border-radius: 5px;
      margin-bottom: 20px;
      overflow: hidden;
    }


    /* Header */
    .order-header {
      background: #f9f9f9;
      padding: 15px;
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid #eee;
    }

    .order-number {
      font-weight: bold;
    }

    .order-datetime {
      text-align: center;
      font-size: 0.9em;
      color: #555;
    }

    .order-date,
    .order-time {
      display: block;
      line-height: 1.2;
    }

    .order-status {
      padding: 5px 10px;
      border-radius: 15px;
      color: #fff;
      text-transform: capitalize;
      font-size: 12px;
      font-weight: bold;
    }

    .order-status.pending {
      background: #fff3cd;
      color: #856404;
    }

    .order-status.confirmed {
      background: #cce5ff;
      color: #004085;
    }

    .order-status.shipping {
      background: #d4edda;
      color: #155724;
    }

    .order-status.delivered {
      background: #5c9d7e;
      color: white;
    }

    .order-status.cancelled {
      background: #f8d7da;
      color: #721c24;
    }

    /* Info grid */
    .order-info-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 16px;
    }

    .info-section h4 {
      margin: 0 0 4px;
      font-size: 0.95em;
      color: #333;
    }

    .info-section p {
      margin: 0;
      font-size: 0.9em;
      color: #666;
    }

    /* Products list */
    .products-section {
      margin-bottom: 16px;
    }

    .products-section h4 {
      margin-bottom: 8px;
    }

    .product-item {
      display: flex;
      align-items: center;
      margin-bottom: 8px;
    }

    .product-item img {
      width: 48px;
      height: 48px;
      object-fit: cover;
      border-radius: 4px;
      margin-right: 12px;
    }

    .product-detail {
      flex: 1;
    }

    .product-name {
      display: block;
      font-weight: 500;
    }

    .product-qty {
      display: block;
      font-size: 0.85em;
      color: #777;
    }

    .product-price {
      font-weight: bold;
    }

    /* Footer */
    .order-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid #eee;
      padding-top: 12px;
    }

    .order-total {
      font-size: 1.1em;
      color: #c9302c;
    }

    .order-actions button {
      margin-left: 0;
    }

    .order-actions .cancel-btn {
      background: #fff;
      color: #c9302c;
      border: 1.5px solid #c9302c;
      font-weight: 600;
      box-shadow: none;
      padding: 7px 18px;
      font-size: 1em;
      border-radius: 5px;
      transition: background 0.2s, color 0.2s, border 0.2s;
      margin-left: 0;
      display: inline-block;
      min-width: 110px;
    }

    .order-actions .cancel-btn:hover,
    .order-actions .cancel-btn:focus {
      background: #f8d7da;
      color: #a71d2a;
      border-color: #a71d2a;
    }

    /* Xoá style cho btn-primary, btn-outline nếu không còn dùng */
    .btn-primary,
    .btn-outline {
      display: none !important;
    }

    /* --- Modern Order Card Styles --- */
    .order-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(60, 72, 88, 0.08);
      margin-bottom: 32px;
      overflow: hidden;
      transition: box-shadow 0.2s;
      border: 1px solid #f0f0f0;
    }

    .order-card:hover {
      box-shadow: 0 4px 24px rgba(60, 72, 88, 0.16);
      border-color: #5c9d7e33;
    }

    .order-header {
      background: linear-gradient(90deg, #e8f5e9 0%, #f1f8e9 100%);
      padding: 18px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #e0e0e0;
    }

    .order-number {
      font-weight: bold;
      font-size: 1.1em;
      color: #5c9d7e;
      letter-spacing: 1px;
    }

    .order-datetime {
      text-align: center;
      font-size: 0.95em;
      color: #888;
    }

    .order-status {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      text-transform: capitalize;
      box-shadow: 0 1px 4px #0001;
      border: none;
      min-width: 110px;
      justify-content: center;
    }

    .order-status.pending {
      background: #fff3cd;
      color: #b8860b;
    }

    .order-status.confirmed {
      background: #cce5ff;
      color: #0056b3;
    }

    .order-status.shipping {
      background: #d4edda;
      color: #218838;
    }

    .order-status.delivered {
      background: #5c9d7e;
      color: #fff;
    }

    .order-status.cancelled {
      background: #f8d7da;
      color: #c9302c;
    }

    .order-status i {
      font-size: 1.1em;
    }

    .order-info-grid {
      display: flex;
      gap: 32px;
      padding: 18px 24px 0 24px;
      background: #fafbfc;
      border-bottom: 1px solid #f0f0f0;
    }

    .info-section h4 {
      margin: 0 0 4px;
      font-size: 1em;
      color: #333;
      font-weight: 600;
    }

    .info-section p {
      margin: 0;
      font-size: 0.97em;
      color: #666;
    }

    .products-section {
      padding: 18px 24px 0 24px;
    }

    .products-section h4 {
      margin-bottom: 10px;
      font-size: 1.05em;
      color: #444;
    }

    .product-item {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      background: #f7f7f7;
      border-radius: 6px;
      padding: 8px 12px;
      transition: background 0.2s;
    }

    .product-item:hover {
      background: #e8f5e9;
    }

    .product-item img {
      width: 54px;
      height: 54px;
      object-fit: cover;
      border-radius: 6px;
      margin-right: 16px;
      border: 1px solid #e0e0e0;
      background: #fff;
    }

    .product-detail {
      flex: 1;
    }

    .product-name {
      font-weight: 600;
      color: #333;
      font-size: 1em;
    }

    .product-qty {
      font-size: 0.92em;
      color: #888;
    }

    .product-price {
      font-weight: bold;
      color: #c9302c;
      font-size: 1.05em;
      margin-left: 12px;
    }

    .order-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid #f0f0f0;
      padding: 16px 24px;
      background: #fafbfc;
    }

    .order-total {
      font-size: 1.15em;
      color: #c9302c;
      font-weight: 700;
    }

    .order-actions button {
      margin-left: 0;
    }

    .order-actions .cancel-btn {
      background: #fff;
      color: #c9302c;
      border: 1.5px solid #c9302c;
      font-weight: 600;
      box-shadow: none;
      padding: 7px 18px;
      font-size: 1em;
      border-radius: 5px;
      transition: background 0.2s, color 0.2s, border 0.2s;
      margin-left: 0;
      display: inline-block;
      min-width: 110px;
    }

    .order-actions .cancel-btn:hover,
    .order-actions .cancel-btn:focus {
      background: #f8d7da;
      color: #a71d2a;
      border-color: #a71d2a;
    }

    /* Thanh kéo riêng cho phần đơn hàng */
    #orders-container {
      max-height: 720px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #5c9d7e #f0f0f0;
      padding-right: 4px;
    }

    #orders-container::-webkit-scrollbar {
      width: 8px;
      background: #f0f0f0;
      border-radius: 8px;
    }

    #orders-container::-webkit-scrollbar-thumb {
      background: #5c9d7e55;
      border-radius: 8px;
    }

    @media (max-width: 900px) {
      #orders-container {
        max-height: 340px;
      }

      .order-info-grid {
        flex-direction: column;
        gap: 12px;
      }

      .order-header,
      .order-footer,
      .products-section {
        padding-left: 12px;
        padding-right: 12px;
      }
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>

  <div id="body">
    <div id="content">
      <div class="content">
        <h2>My Orders</h2>

        <div class="orders-container">
          <div class="order-tabs">
            <div class="order-tab active">All Orders</div>
            <div class="order-tab">Pending</div>
            <div class="order-tab">Confirmed</div>
            <div class="order-tab">Shipping</div>
            <div class="order-tab">Delivered</div>
            <div class="order-tab">Canceled</div>
          </div>

          <!-- container rỗng để JS đổ đơn hàng vào -->
          <div id="orders-container"></div>

          <!-- Hiển thị khi không có đơn hàng nào (ẩn mặc định) -->
          <div class="empty-orders" style="display: none;">
            <img src="/api/placeholder/150/150" alt="No Orders">
            <h3>No orders found</h3>
            <p>You haven't placed any orders yet. Start shopping and discover our amazing pet products!</p>
            <a href="petmart.php" class="checkout-btn"
              style="display: inline-block; width: auto; text-decoration: none;">Start Shopping</a>
          </div>
        </div>
      </div>

      <div id="sidebar">
        <div id="section">
          <div>
            <div>
               <h2 style="color:#111; font-size:1.18em; margin-bottom:10px; letter-spacing:0.5px; font-weight:bold;">Purchase History Overview</h2>
              <div id="order-summary" style="padding: 16px 18px 18px 18px; background: #f8f9fa; border-radius: 10px; box-shadow: 0 2px 8px #5c9d7e11; margin-bottom: 18px;">
                <ul style="list-style:none;padding:0;margin:0;">
                  <li style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span style="color:#888;font-weight:600;display:flex;align-items:center;"><i class="fa fa-list-alt" style="margin-right:7px;"></i>Total Orders</span>
                    <span id="summary-total-orders" style="font-weight:700;font-size:1.08em;color:#888;">–</span>
                  </li>
                  <li style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span style="color:#888;font-weight:600;display:flex;align-items:center;"><i class="fa fa-box-open" style="margin-right:7px;"></i>Delivered</span>
                    <span id="summary-delivered-orders" style="font-weight:700;font-size:1.08em;color:#888;">–</span>
                  </li>
                  <li style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span style="color:#888;font-weight:600;display:flex;align-items:center;"><i class="fa fa-ban" style="margin-right:7px;"></i>Cancelled</span>
                    <span id="summary-cancelled-orders" style="font-weight:700;font-size:1.08em;color:#888;">–</span>
                  </li>
                  <li style="display:flex;align-items:center;justify-content:space-between;">
                    <span style="color:#888;font-weight:600;display:flex;align-items:center;"><i class="fa fa-coins" style="margin-right:7px;"></i>Total Spent</span>
                    <span id="summary-total-spent" style="font-weight:700;font-size:1.08em;color:#888;">–</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div id="section">
          <div>
            <div>
              <h2>Đánh giá sản phẩm đã mua</h2>
              <div id="review-reminder" style="padding: 10px 0;">
                <p>Danh sách các sản phẩm bạn đã mua. Nhấn "Mua lại" để đặt hàng lại sản phẩm yêu thích!</p>
                <ul id="review-products-list" style="list-style: none; padding: 0; margin: 0;"></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="featured">
      <ul>
        <li><a href="#"><img src="images/organic-and-chemical-free.jpg" width="300" height="90" alt=""></a></li>
        <li><a href="#"><img src="images/good-food.jpg" width="300" height="90" alt=""></a></li>
        <li class="last"><a href="#"><img src="images/pet-grooming.jpg" width="300" height="90" alt=""></a></li>
      </ul>
    </div>
  </div>

  <div id="footer">
    <div class="section">
      <ul>
        <li> <img src="images/friendly-pets.jpg" width="240" height="186" alt="">
          <h2><a href="#">Friendly Pets</a></h2>
          <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonummy nib. <a class="more"
              href="#">Read More</a> </p>
        </li>
        <li> <img src="images/pet-lover2.jpg" width="240" height="186" alt="">
          <h2><a href="#">How dangerous are they</a></h2>
          <p> Lorem ipsum dolor sit amet, cons ectetuer adepis cing, sed diam euis. <a class="more"
              href="#">Read More</a> </p>
        </li>
        <li> <img src="images/healthy-dog.jpg" width="240" height="186" alt="">
          <h2><a href="#">Keep them healthy</a></h2>
          <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonu mmy. <a class="more"
              href="#">Read More</a> </p>
        </li>
        <li>
          <h2><a href="#">Love...love...love...pets</a></h2>
          <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diameusim. <a class="more"
              href="#">Read More</a> </p>
          <img src="images/pet-lover.jpg" width="240" height="186" alt="">
        </li>
      </ul>
    </div>
    <div id="footnote">
      <div class="section">Copyright &copy; 2012 <a href="#">Company Name</a> All rights reserved | Website Template By
        <a target="_blank" href="http://www.freewebsitetemplates.com/">freewebsitetemplates.com</a></div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Lấy user_id từ token trong localStorage
      const token = localStorage.getItem('token');
      if (!token) {
        console.error('Token không tồn tại trong localStorage.');
        alert('Bạn cần đăng nhập để xem đơn hàng.');
        window.location.href = 'login.php';
        return;
      }

      // Giải mã token để lấy user_id
      let currentUserId;
      try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        currentUserId = payload.user_id;
        console.log('Lấy user_id từ token thành công:', currentUserId);
      } catch (e) {
        console.error('Lỗi khi giải mã token:', e);
        alert('Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.');
        window.location.href = 'login.php';
        return;
      }

      // Sử dụng currentUserId trong các hàm khác
      const tabs = Array.from(document.querySelectorAll('.order-tab'));
      const listContainer = document.getElementById('orders-container');

      // map tab index → status filter (All = null)
      const statuses = [null, 'pending', 'confirmed', 'shipping', 'delivered', 'cancelled'];

      async function fetchProduct(productId) {
        const res = await fetch(`http://localhost:3000/product-service/products/${productId}`);
        const product = await res.json();
        return product.product;
      }

      async function fetchAndRender(status) {
        const url = `http://localhost:3000/order-service/user/${currentUserId}`;
        let data = [];
        try {
          const res = await fetch(url);
          data = await res.json();
        } catch (e) {
          listContainer.innerHTML = '<p>Không thể tải đơn hàng</p>';
          return;
        }

        const filtered = status ? data.filter(e => e.order.status === status) : data;
        await renderList(filtered);
      }

      async function renderList(list) {
        listContainer.innerHTML = '';

        if (!list.length) {
          listContainer.innerHTML = '<p>Không có đơn hàng</p>';
          return;
        }

        for (const entry of list) {
          const o = entry.order;
          const items = entry.items;

          // Fetch product info cho từng item
          const itemsWithDetails = await Promise.all(items.map(async it => {
            const product = await fetchProduct(it.product_id);
            console.log('Fetched product:', product);
            return {
              ...it,
              product_name: product.name,
              image_url: product.image,
              category: product.category
            };
          }));

          const dt = new Date(o.updated_at);
          const date = dt.toLocaleDateString(undefined, {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
          });
          const time = dt.toLocaleTimeString(undefined, {
            hour: '2-digit',
            minute: '2-digit'
          });
          const total = Number(o.total_price).toLocaleString();
          const canCancel = (o.status === 'pending');
          const shippingFee = 5;
          const totalWithShipping = Number(o.total_price) + shippingFee;

          const card = document.createElement('div');
          card.className = 'order-card';

          card.innerHTML = `
            <div class="order-header">
              <span class="order-number"><i class="fa fa-receipt" style="margin-right:6px;color:#5c9d7e;"></i>Order #${o.order_id}</span>
              <span class="order-datetime">
                <span class="order-date"><i class="fa fa-calendar-alt" style="margin-right:4px;"></i>${date}</span>
                <span class="order-time"><i class="fa fa-clock" style="margin-right:4px;"></i>${time}</span>
              </span>
              <span class="order-status ${o.status}">
                ${o.status === 'pending' ? '<i class=\'fa fa-hourglass-half\'></i>' : ''}
                ${o.status === 'confirmed' ? '<i class=\'fa fa-check-circle\'></i>' : ''}
                ${o.status === 'shipping' ? '<i class=\'fa fa-truck\'></i>' : ''}
                ${o.status === 'delivered' ? '<i class=\'fa fa-box-open\'></i>' : ''}
                ${o.status === 'cancelled' ? '<i class=\'fa fa-times-circle\'></i>' : ''}
                ${o.status}
              </span>
            </div>

            <div class="order-info-grid">
              <div class="info-section">
                <h4><i class="fa fa-map-marker-alt" style="margin-right:4px;color:#5c9d7e;"></i>Shipping Address</h4>
                <p>${o.shipping_address}</p>
              </div>
              <div class="info-section">
                <h4><i class="fa fa-credit-card" style="margin-right:4px;color:#5c9d7e;"></i>Payment Method</h4>
                <p>${o.payment_method || '–'}</p>
              </div>
              <div class="info-section">
                <h4><i class="fa fa-user" style="margin-right:4px;color:#5c9d7e;"></i>Contact</h4>
                <p>${o.phone_number}<br><span id="contact-email-${o.order_id}">Đang tải email...</span></p>
              </div>
            </div>

            <div class="products-section">
              <div style="display:flex;align-items:center;justify-content:space-between;">
                <h4 style="margin-bottom:0;"><i class="fa fa-shopping-bag" style="margin-right:4px;color:#5c9d7e;"></i>Products (${itemsWithDetails.length})</h4>
                <button class="toggle-products-btn" data-order-id="${o.order_id}" aria-label="Ẩn/hiện sản phẩm" style="background:none;border:none;cursor:pointer;font-size:1.2em;color:#888;display:flex;align-items:center;justify-content:center;">
                  <img src="images/arrow-down.gif" class="toggle-arrow" style="width:17px;height:13px;transition:transform 0.2s;transform:rotate(-90deg);" />
                </button>
              </div>
              <div class="products-list-detail" id="products-list-detail-${o.order_id}" style="display:none;">
                ${itemsWithDetails.map(it => `
                  <div class="product-item">
                    <img src="../backend/image/${it.category}/${it.image_url || 'placeholder.jpg'}" alt="Product ${it.product_id}">
                    <div class="product-detail">
                      <span class="product-name">${it.product_name || 'Product ' + it.product_id}</span>
                      <span class="product-qty">Quantity: ${it.quantity}</span>
                    </div>
                    <span class="product-price" style="color:#111;">${Number(it.price).toLocaleString()} đ</span>
                  </div>
                `).join('')}
              </div>
              <div class="order-math" id="order-math-${o.order_id}" style="margin: 18px 0 0 0; padding: 14px 18px; background: #f8f9fa; border-radius: 8px; font-size: 1.05em;">
                <div class="order-math-detail" style="display: none; flex-direction: column; gap: 8px;">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color:#888;">Subtotal</span>
                    <strong>${Number(o.total_price).toLocaleString()} đ</strong>
                  </div>
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color:#888;">Shipping</span>
                    <strong>${shippingFee.toLocaleString()} đ</strong>
                  </div>
                </div>
                <div class="order-math-total" style="display: flex; align-items: center; justify-content: flex-end; margin-top: 8px; gap: 8px;">
                  <span style="color:#888;">Total</span>
                  <strong style="color:#c9302c; font-size:1.13em; margin-left:0;">${totalWithShipping.toLocaleString()} đ</strong>
                  <button class="toggle-math-btn" data-order-id="${o.order_id}" aria-label="Ẩn/hiện chi tiết" style="background:none;border:none;cursor:pointer;font-size:1.2em;color:#888;display:flex;align-items:center;justify-content:center;margin-left:6px;">
                    <img src="images/arrow-down.gif" class="toggle-math-arrow" style="width:17px;height:13px;transition:transform 0.2s;" />
                  </button>
                </div>
              </div>
            </div>

            <div class="order-footer">
              <div class="order-actions">
                ${canCancel ? `<button class="cancel-btn" data-order-id="${o.order_id}">Cancel Order</button>` : ''}
              </div>
            </div>
          `;

          listContainer.appendChild(card);

          // Sau khi render xong card, gọi hàm fetchUserEmail để lấy email và cập nhật vào phần contact
          fetchUserEmail(o.user_id).then(email => {
            document.getElementById(`contact-email-${o.order_id}`).textContent = email || 'Không có email';
          });

          // Thêm sự kiện toggle chi tiết phép tính (ẩn/hiện tuỳ chỉnh, dùng icon)
          const mathDiv = document.getElementById(`order-math-${o.order_id}`);
          const mathDetail = mathDiv ? mathDiv.querySelector('.order-math-detail') : null;
          const toggleBtn = mathDiv ? mathDiv.querySelector('.toggle-math-btn') : null;
          const mathArrow = mathDiv ? mathDiv.querySelector('.toggle-math-arrow') : null;
          let isDetailVisible = false;
          if (toggleBtn && mathDetail && mathArrow) {
            mathDetail.style.display = 'none';
            mathArrow.style.transform = 'rotate(-90deg)';
            toggleBtn.addEventListener('click', function(e) {
              e.stopPropagation();
              isDetailVisible = !isDetailVisible;
              if (isDetailVisible) {
                mathDetail.style.display = '';
                mathArrow.style.transform = 'rotate(0deg)';
                toggleBtn.setAttribute('aria-label', 'Ẩn chi tiết');
              } else {
                mathDetail.style.display = 'none';
                mathArrow.style.transform = 'rotate(-90deg)';
                toggleBtn.setAttribute('aria-label', 'Hiện chi tiết');
              }
            });
          }

          // Thêm sự kiện toggle ẩn/hiện sản phẩm
          const toggleProductsBtn = card.querySelector('.toggle-products-btn');
          const productsListDetail = card.querySelector('.products-list-detail');
          const arrowIcon = toggleProductsBtn ? toggleProductsBtn.querySelector('.toggle-arrow') : null;
          let isProductsVisible = false;
          if (toggleProductsBtn && productsListDetail && arrowIcon) {
            productsListDetail.style.display = 'none';
            arrowIcon.style.transform = 'rotate(-90deg)';
            toggleProductsBtn.addEventListener('click', function(e) {
              e.stopPropagation();
              isProductsVisible = !isProductsVisible;
              if (isProductsVisible) {
                productsListDetail.style.display = '';
                arrowIcon.style.transform = 'rotate(0deg)';
                toggleProductsBtn.setAttribute('aria-label', 'Ẩn sản phẩm');
              } else {
                productsListDetail.style.display = 'none';
                arrowIcon.style.transform = 'rotate(-90deg)';
                toggleProductsBtn.setAttribute('aria-label', 'Hiện sản phẩm');
              }
            });
          }
        }

        // Add event listeners for cancel buttons
        document.querySelectorAll('.cancel-btn').forEach(button => {
          button.addEventListener('click', async (e) => {
            const orderId = e.target.dataset.orderId;
            const confirmCancel = confirm('Bạn có chắc muốn huỷ đơn hàng này không?');
            if (!confirmCancel) return;

            try {
              const response = await fetch(`http://localhost:3000/order-service/${orderId}/cancel`, {
                method: 'PUT',
                headers: {
                  'Content-Type': 'application/json'
                }
              });

              if (response.ok) {
                alert('Huỷ đơn hàng thành công');
                fetchAndRender(null);
                fetchOrderSummary(); // Cập nhật lại lịch sử tổng quan
              } else {
                const error = await response.json();
                alert(error.message || 'Lỗi khi huỷ đơn hàng');
              }
            } catch (err) {
              console.error('Lỗi khi huỷ đơn hàng:', err);
              alert('Lỗi khi huỷ đơn hàng: ' + err.message);
            }
          });
        });
      }

      // Add click handlers for tabs
      tabs.forEach((tab, i) => {
        tab.addEventListener('click', () => {
          tabs.forEach(t => t.classList.remove('active'));
          tab.classList.add('active');
          fetchAndRender(statuses[i]);
        });
      });

      // Initial load
      fetchAndRender(null);
      // Lịch sử mua hàng tổng quan
      async function fetchOrderSummary() {
        const token = localStorage.getItem('token');
        if (!token) return;
        let currentUserId;
        try {
          const payload = JSON.parse(atob(token.split('.')[1]));
          currentUserId = payload.user_id;
        } catch (e) { return; }
        const res = await fetch(`http://localhost:3000/order-service/user/${currentUserId}`);
        const orders = await res.json();
        let totalOrders = orders.length;
        let delivered = 0, cancelled = 0, totalSpent = 0;
        orders.forEach(e => {
          if (e.order.status === 'delivered') {
            delivered++;
            totalSpent += Number(e.order.total_price || 0) + 5;
          }
          if (e.order.status === 'cancelled') cancelled++;
        });
        document.getElementById('summary-total-orders').textContent = totalOrders;
        document.getElementById('summary-delivered-orders').textContent = delivered;
        document.getElementById('summary-cancelled-orders').textContent = cancelled;
        document.getElementById('summary-total-spent').textContent = totalSpent.toLocaleString() + ' đ';
      }
      fetchOrderSummary();

      // Gợi ý đánh giá sản phẩm đã mua
      async function fetchRecentProductsToReview() {
        const token = localStorage.getItem('token');
        if (!token) return;
        let currentUserId;
        try {
          const payload = JSON.parse(atob(token.split('.')[1]));
          currentUserId = payload.user_id;
        } catch (e) { return; }
        // Lấy tất cả đơn hàng
        const res = await fetch(`http://localhost:3000/order-service/user/${currentUserId}`);
        const orders = await res.json();
        // Chỉ lấy sản phẩm từ đơn hàng đã giao
        const products = [];
        orders.filter(entry => entry.order.status === 'delivered').forEach(entry => {
          entry.items.forEach(it => {
            console.log('Fetched product:', it);
            products.push({
              product_id: it.id,
              name: it.name || 'Sản phẩm',
              image: it.image || 'placeholder.jpg',
              category: it.category || ''
            });
            console.log('Product:', products);
          });
        });
        // Hiển thị tối đa 6 sản phẩm gần nhất
        const list = document.getElementById('review-products-list');
        if (!list) return;
        list.innerHTML = '';
        if (products.length === 0) {
          list.innerHTML = '<li>Không có sản phẩm nào đã mua.</li>';
        } else {
          products.slice(0,6).forEach(p => {
            console.log('Product:', p);
            const li = document.createElement('li');
            li.style.display = 'flex';
            li.style.alignItems = 'center';
            li.style.marginBottom = '10px';
            li.innerHTML = `
              <img src="../backend/image/${p.category}/${p.image}" alt="${p.name}" style="width:38px;height:38px;object-fit:cover;border-radius:5px;margin-right:10px;border:1px solid #eee;background:#fff;">
              <span style="flex:1;">${p.name}</span>
              <a href="petmart.php?id=${p.product_id}" style="margin-left:8px;color:#5c9d7e;font-weight:600;text-decoration:underline;font-size:0.97em;">Mua lại</a>
            `;
            list.appendChild(li);
          });
        }
      }
      fetchRecentProductsToReview();

      // Thêm hàm fetchUserEmail vào script
      async function fetchUserEmail(userId) {
        try {
          const res = await fetch(`http://localhost:3000/user-service/user/${userId}`);
          if (!res.ok) return null;
          const data = await res.json();
          return data.email || null;
        } catch (e) {
          return null;
        }
      }
    });
  </script>

</body>

</html>