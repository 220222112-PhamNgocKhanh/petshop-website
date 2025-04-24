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
  
  .order-header {
    background: #f9f9f9;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #eee;
  }
  
  .order-date {
    font-weight: bold;
  }
  
  .order-status {
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
  }
  
  .status-pending {
    background: #fff3cd;
    color: #856404;
  }
  
  .status-processing {
    background: #cce5ff;
    color: #004085;
  }
  
  .status-shipped {
    background: #d4edda;
    color: #155724;
  }
  
  .status-delivered {
    background: #5c9d7e;
    color: white;
  }
  
  .status-canceled {
    background: #f8d7da;
    color: #721c24;
  }
  
  .order-info {
    display: flex;
    padding: 15px;
    border-bottom: 1px solid #eee;
  }
  
  .order-info div {
    flex: 1;
  }
  
  .order-info h4 {
    font-size: 14px;
    color: #777;
    margin-bottom: 5px;
  }
  
  .order-products {
    padding: 15px;
  }
  
  .product-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
  }
  
  .product-item:last-child {
    border-bottom: none;
  }
  
  .product-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    margin-right: 15px;
  }
  
  .product-details {
    flex: 1;
  }
  
  .product-price {
    font-weight: bold;
    white-space: nowrap;
  }
  
  .order-footer {
    background: #f9f9f9;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .order-total {
    font-weight: bold;
    font-size: 16px;
  }
  
  .order-actions button {
    padding: 8px 15px;
    background: #5c9d7e;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
  }
  
  .order-details-btn {
    background: transparent !important;
    color: #5c9d7e !important;
    border: 1px solid #5c9d7e !important;
  }
  
  .empty-orders {
    text-align: center;
    padding: 50px 0;
  }
  
  .empty-orders p {
    margin-bottom: 20px;
    color: #777;
  }
  
  .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
  
  .pagination a {
    padding: 8px 12px;
    margin: 0 5px;
    border: 1px solid #ddd;
    color: #5c9d7e;
    text-decoration: none;
    border-radius: 4px;
  }
  
  .pagination a.active {
    background: #5c9d7e;
    color: white;
    border-color: #5c9d7e;
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
          <div class="order-tab">Processing</div>
          <div class="order-tab">Shipped</div>
          <div class="order-tab">Delivered</div>
          <div class="order-tab">Canceled</div>
        </div>
        
        <!-- Danh sách đơn hàng -->
        <div class="order-list">
          <!-- Đơn hàng 1 -->
          <div class="order-item">
            <div class="order-header">
              <div class="order-id">Order #ORD12345</div>
              <div class="order-date">12 Apr, 2025</div>
              <div class="order-status status-delivered">Delivered</div>
            </div>
            
            <div class="order-info">
              <div>
                <h4>Shipping Address</h4>
                <p>123 Pet Street, Animalia, CA 90210</p>
              </div>
              <div>
                <h4>Payment Method</h4>
                <p>Credit Card (**** 4567)</p>
              </div>
              <div>
                <h4>Contact</h4>
                <p>customer@example.com</p>
                <p>(123) 456-7890</p>
              </div>
            </div>
            
            <div class="order-products">
              <h4>Products (3)</h4>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Dog Food" class="product-img">
                <div class="product-details">
                  <h4>Premium Dog Food</h4>
                  <p>Quantity: 1</p>
                </div>
                <div class="product-price">$45.99</div>
              </div>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Cat Toy" class="product-img">
                <div class="product-details">
                  <h4>Interactive Cat Toy</h4>
                  <p>Quantity: 2</p>
                </div>
                <div class="product-price">$25.00</div>
              </div>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Pet Bed" class="product-img">
                <div class="product-details">
                  <h4>Comfortable Pet Bed</h4>
                  <p>Quantity: 1</p>
                </div>
                <div class="product-price">$35.00</div>
              </div>
            </div>
            
            <div class="order-footer">
              <div class="order-total">Total: $110.99</div>
              <div class="order-actions">
                <button class="order-details-btn">View Details</button>
                <button>Buy Again</button>
              </div>
            </div>
          </div>
          
          <!-- Đơn hàng 2 -->
          <div class="order-item">
            <div class="order-header">
              <div class="order-id">Order #ORD12346</div>
              <div class="order-date">5 Apr, 2025</div>
              <div class="order-status status-shipped">Shipped</div>
            </div>
            
            <div class="order-info">
              <div>
                <h4>Shipping Address</h4>
                <p>123 Pet Street, Animalia, CA 90210</p>
              </div>
              <div>
                <h4>Payment Method</h4>
                <p>PayPal</p>
              </div>
              <div>
                <h4>Contact</h4>
                <p>customer@example.com</p>
                <p>(123) 456-7890</p>
              </div>
            </div>
            
            <div class="order-products">
              <h4>Products (2)</h4>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Pet Shampoo" class="product-img">
                <div class="product-details">
                  <h4>Organic Pet Shampoo</h4>
                  <p>Quantity: 2</p>
                </div>
                <div class="product-price">$24.00</div>
              </div>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Dog Leash" class="product-img">
                <div class="product-details">
                  <h4>Durable Dog Leash</h4>
                  <p>Quantity: 1</p>
                </div>
                <div class="product-price">$18.50</div>
              </div>
            </div>
            
            <div class="order-footer">
              <div class="order-total">Total: $47.50</div>
              <div class="order-actions">
                <button class="order-details-btn">View Details</button>
                <button>Track Package</button>
              </div>
            </div>
          </div>
          
          <!-- Đơn hàng 3 -->
          <div class="order-item">
            <div class="order-header">
              <div class="order-id">Order #ORD12347</div>
              <div class="order-date">28 Mar, 2025</div>
              <div class="order-status status-processing">Processing</div>
            </div>
            
            <div class="order-info">
              <div>
                <h4>Shipping Address</h4>
                <p>123 Pet Street, Animalia, CA 90210</p>
              </div>
              <div>
                <h4>Payment Method</h4>
                <p>Credit Card (**** 4567)</p>
              </div>
              <div>
                <h4>Contact</h4>
                <p>customer@example.com</p>
                <p>(123) 456-7890</p>
              </div>
            </div>
            
            <div class="order-products">
              <h4>Products (1)</h4>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Fish Tank" class="product-img">
                <div class="product-details">
                  <h4>Luxury Aquarium Set</h4>
                  <p>Quantity: 1</p>
                </div>
                <div class="product-price">$129.99</div>
              </div>
            </div>
            
            <div class="order-footer">
              <div class="order-total">Total: $134.99</div>
              <div class="order-actions">
                <button class="order-details-btn">View Details</button>
                <button>Contact Support</button>
              </div>
            </div>
          </div>
          
          <!-- Đơn hàng 4 -->
          <div class="order-item">
            <div class="order-header">
              <div class="order-id">Order #ORD12348</div>
              <div class="order-date">15 Mar, 2025</div>
              <div class="order-status status-pending">Pending</div>
            </div>
            
            <div class="order-info">
              <div>
                <h4>Shipping Address</h4>
                <p>123 Pet Street, Animalia, CA 90210</p>
              </div>
              <div>
                <h4>Payment Method</h4>
                <p>Bank Transfer</p>
              </div>
              <div>
                <h4>Contact</h4>
                <p>customer@example.com</p>
                <p>(123) 456-7890</p>
              </div>
            </div>
            
            <div class="order-products">
              <h4>Products (2)</h4>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Bird Cage" class="product-img">
                <div class="product-details">
                  <h4>Premium Bird Cage</h4>
                  <p>Quantity: 1</p>
                </div>
                <div class="product-price">$89.99</div>
              </div>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Bird Food" class="product-img">
                <div class="product-details">
                  <h4>Organic Bird Food</h4>
                  <p>Quantity: 3</p>
                </div>
                <div class="product-price">$29.97</div>
              </div>
            </div>
            
            <div class="order-footer">
              <div class="order-total">Total: $124.96</div>
              <div class="order-actions">
                <button class="order-details-btn">View Details</button>
                <button>Cancel Order</button>
              </div>
            </div>
          </div>
          
          <!-- Đơn hàng 5 -->
          <div class="order-item">
            <div class="order-header">
              <div class="order-id">Order #ORD12349</div>
              <div class="order-date">2 Mar, 2025</div>
              <div class="order-status status-canceled">Canceled</div>
            </div>
            
            <div class="order-info">
              <div>
                <h4>Shipping Address</h4>
                <p>123 Pet Street, Animalia, CA 90210</p>
              </div>
              <div>
                <h4>Payment Method</h4>
                <p>Credit Card (**** 4567)</p>
              </div>
              <div>
                <h4>Contact</h4>
                <p>customer@example.com</p>
                <p>(123) 456-7890</p>
              </div>
            </div>
            
            <div class="order-products">
              <h4>Products (1)</h4>
              <div class="product-item">
                <img src="/api/placeholder/60/60" alt="Pet Carrier" class="product-img">
                <div class="product-details">
                  <h4>Travel Pet Carrier</h4>
                  <p>Quantity: 1</p>
                </div>
                <div class="product-price">$65.00</div>
              </div>
            </div>
            
            <div class="order-footer">
              <div class="order-total">Total: $70.00</div>
              <div class="order-actions">
                <button class="order-details-btn">View Details</button>
                <button>Buy Again</button>
              </div>
            </div>
          </div>
        </div>
        
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
        <img src="images/pet-lover.jpg" width="240" height="186" alt=""> </li>
    </ul>
  </div>
  <div id="footnote">
    <div class="section">Copyright &copy; 2012 <a href="#">Company Name</a> All rights reserved | Website Template By <a target="_blank" href="http://www.freewebsitetemplates.com/">freewebsitetemplates.com</a></div>
  </div>
</div>

<script>
  // JavaScript để xử lý chức năng tab của đơn hàng
  document.addEventListener('DOMContentLoaded', function() {
    const orderTabs = document.querySelectorAll('.order-tab');
    
    orderTabs.forEach(tab => {
      tab.addEventListener('click', function() {
        // Xóa lớp active từ tất cả các tab
        orderTabs.forEach(t => t.classList.remove('active'));
        
        // Thêm lớp active vào tab đã click
        this.classList.add('active');
        
        // Logic lọc đơn hàng theo tab sẽ được thêm vào đây
        // Hiện tại chỉ là UI demo, nên chưa có chức năng thực tế
      });
    });
  });
</script>
</body>
</html>