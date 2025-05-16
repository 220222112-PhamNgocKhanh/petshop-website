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
      margin-left: 8px;
      padding: 6px 14px;
      border-radius: 4px;
      border: 1px solid transparent;
      cursor: pointer;
    }

    .btn-primary {
      background: #5cb85c;
      color: #fff;
      border-color: #4cae4c;
    }

    .btn-outline {
      background: transparent;
      color: #5cb85c;
      border-color: #5cb85c;
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
            <a href="petmart.php" class="checkout-btn" style="display: inline-block; width: auto; text-decoration: none;">Start Shopping</a>
          </div>

          <!-- Phân trang -->
          <div class="pagination">
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">&raquo;</a>
          </div>
        </div>
      </div>

      <div id="sidebar">
        <div id="section">
          <div>
            <div>
              <h2>Order Information</h2>
              <ul>
                <li><a href="#">Order Status Guide <span></span></a></li>
                <li><a href="#">Shipping Policy <span></span></a></li>
                <li><a href="#">Return & Refund <span></span></a></li>
                <li><a href="#">Order FAQ <span></span></a></li>
                <li><a href="#">Track Your Order <span></span></a></li>
              </ul>
            </div>
          </div>
        </div>

        <div id="section">
          <div>
            <div>
              <h2>Need Help?</h2>
              <p>Our customer service team is ready to assist you with any questions about your orders.</p>
              <a href="contact.php" class="checkout-btn" style="display: block; width: auto; text-align: center; margin-top: 15px; text-decoration: none;">Contact Support</a>
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
          <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonummy nib. <a class="more" href="#">Read More</a> </p>
        </li>
        <li> <img src="images/pet-lover2.jpg" width="240" height="186" alt="">
          <h2><a href="#">How dangerous are they</a></h2>
          <p> Lorem ipsum dolor sit amet, cons ectetuer adepis cing, sed diam euis. <a class="more" href="#">Read More</a> </p>
        </li>
        <li> <img src="images/healthy-dog.jpg" width="240" height="186" alt="">
          <h2><a href="#">Keep them healthy</a></h2>
          <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonu mmy. <a class="more" href="#">Read More</a> </p>
        </li>
        <li>
          <h2><a href="#">Love...love...love...pets</a></h2>
          <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diameusim. <a class="more" href="#">Read More</a> </p>
          <img src="images/pet-lover.jpg" width="240" height="186" alt="">
        </li>
      </ul>
    </div>
    <div id="footnote">
      <div class="section">Copyright &copy; 2012 <a href="#">Company Name</a> All rights reserved | Website Template By <a target="_blank" href="http://www.freewebsitetemplates.com/">freewebsitetemplates.com</a></div>
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

          const card = document.createElement('div');
          card.className = 'order-card';

          card.innerHTML = `
            <div class="order-header">
              <span class="order-number">Order #${o.order_id}</span>
              <span class="order-datetime">
                <span class="order-date">${date}</span>
                <span class="order-time">${time}</span>
              </span>
              <span class="order-status ${o.status}">${o.status}</span>
            </div>

            <div class="order-info-grid">
              <div class="info-section">
                <h4>Shipping Address</h4>
                <p>${o.shipping_address}</p>
              </div>
              <div class="info-section">
                <h4>Payment Method</h4>
                <p>${o.payment_method || '–'}</p>
              </div>
              <div class="info-section">
                <h4>Contact</h4>
                <p>${o.contact_email || '–'}<br>${o.contact_phone || '–'}</p>
              </div>
            </div>

            <div class="products-section">
              <h4>Products (${itemsWithDetails.length})</h4>
              ${itemsWithDetails.map(it => `
                <div class="product-item">
                  <img src="../backend/image/${it.category}/${it.image_url || 'placeholder.jpg'}" alt="Product ${it.product_id}">
                  <div class="product-detail">
                    <span class="product-name">${it.product_name || 'Product ' + it.product_id}</span>
                    <span class="product-qty">Quantity: ${it.quantity}</span>
                  </div>
                  <span class="product-price">${Number(it.price).toLocaleString()} đ</span>
                </div>
              `).join('')}
            </div>

            <div class="order-footer">
              <div class="order-total">Total: <strong>${total} đ</strong></div>
              <div class="order-actions">
                <button class="btn-outline">View Details</button>
                <button class="btn-primary">Buy Again</button>
                ${canCancel ? `<button class="cancel-btn" data-order-id="${o.order_id}">Cancel Order</button>` : ''}
              </div>
            </div>
          `;

          listContainer.appendChild(card);
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
    });
  </script>

</body>

</html>