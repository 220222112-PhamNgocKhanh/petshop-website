<!DOCTYPE html>
<html>

<head>
  <title>Orders | PetGuide</title>
  <meta charset="iso-8859-1">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/header.css" rel="stylesheet" type="text/css">
  <link href="css/order.css" rel="stylesheet" type="text/css">
  <!--[if IE 6]><link href="css/ie6.css" rel="stylesheet" type="text/css"><![endif]-->
  <!--[if IE 7]><link href="css/ie7.css" rel="stylesheet" type="text/css"><![endif]-->
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
              <h2>Purchased Products</h2>
              <div id="review-reminder" style="padding: 10px 0;">
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

      async function fetchPaymentDetails(orderId) {
        try {
          const res = await fetch(`http://localhost:3000/payment-service/payments/${orderId}`);
          if (!res.ok) return null;
          const data = await res.json();
          return data;
        } catch (e) {
          console.error('Error fetching payment details:', e);
          return null;
        }
      }

      async function fetchAndRender(status) {
        const url = `http://localhost:3000/order-service/user/${currentUserId}`;
        let data = [];
        try {
          const res = await fetch(url);
          data = await res.json();
        } catch (e) {
          listContainer.innerHTML = '<p>Could not load orders</p>';
          return;
        }

        // Sort orders by updated_at descending (newest first)
        data.sort((a, b) => new Date(b.order.updated_at) - new Date(a.order.updated_at));

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
            return {
              ...it,
              product_name: product.name,
              image_url: product.image,
              category: product.category
            };
          }));

          // Fetch payment details
          const paymentDetails = await fetchPaymentDetails(o.order_id);
          const paymentMethod = paymentDetails ? paymentDetails.payment_method : '–';

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
                <p>${paymentMethod}</p>
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
        const productIds = new Set();
        for (const entry of orders.filter(entry => entry.order.status === 'delivered')) {
          for (const it of entry.items) {
            // Tránh trùng sản phẩm
            const pid = it.id || it.product_id;
            if (!pid || productIds.has(pid)) continue;
            productIds.add(pid);
            try {
              const pres = await fetch(`http://localhost:3000/product-service/products/${pid}`);
              if (!pres.ok) continue;
              const pdata = await pres.json();
              const p = pdata.product || {};
              products.push({
                product_id: pid,
                name: p.name || 'Sản phẩm',
                image: p.image || 'placeholder.jpg',
                category: p.category || ''
              });
            } catch (e) { continue; }
          }
        }
        // Hiển thị tối đa 6 sản phẩm gần nhất
        const list = document.getElementById('review-products-list');
        if (!list) return;
        list.innerHTML = '';
        if (products.length === 0) {
          list.innerHTML = '<li>No purchased products found.</li>';
        } else {
          products.slice(0,6).forEach(p => {
            const li = document.createElement('li');
            li.style.display = 'flex';
            li.style.alignItems = 'center';
            li.style.marginBottom = '10px';
            li.innerHTML = `
              <img src="../backend/image/${p.category}/${p.image}" alt="${p.name}" style="width:38px;height:38px;object-fit:cover;border-radius:5px;margin-right:10px;border:1px solid #eee;background:#fff;">
              <span style="flex:1;">${p.name}</span>
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