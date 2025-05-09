<!DOCTYPE html>
<html>

<head>
  <title>Shopping Cart | PetGuide</title>
  <meta charset="iso-8859-1">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/header.css" rel="stylesheet" type="text/css">
  <link href="css/cart.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../cart-service/public/css/toast.css">
  <!--[if IE 6]><link href="css/ie6.css" rel="stylesheet" type="text/css"><![endif]-->
  <!--[if IE 7]><link href="css/ie7.css" rel="stylesheet" type="text/css"><![endif]-->

</head>

<body>
  <?php include 'header.php'; ?>

  <div id="body">
    <div id="content">
      <div class="content">
        <h2>Shopping Cart</h2>

        <div class="cart-container">
          <!-- Giỏ hàng có sản phẩm -->
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="cart-body">
              <!-- Sản phẩm sẽ được thêm động vào đây -->
            </tbody>
          </table>

          <div class="cart-summary">
            <div class="cart-total">
              <span>Subtotal:</span>
              <span id="subtotal-amount">$0.00</span>
            </div>
            <div class="cart-total">
              <span>Shipping:</span>
              <span id="shipping-amount">$5.00</span>
            </div>
            <div class="cart-total">
              <span>Total:</span>
              <span id="total-amount">$0.00</span>
            </div>

            <button class="checkout-btn">Proceed to Checkout</button>
            <a href="petmart.php" class="continue-shopping">Continue Shopping</a>
          </div>


          <!-- Giỏ hàng trống (ẩn mặc định) -->
          <div class="empty-cart" style="display: none;">
            <!-- <img src="/api/placeholder/150/150" alt="Empty Cart"> -->
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any products to your cart yet.</p>
            <a href="petmart.php" class="checkout-btn" style="display: inline-block; width: auto;">Start Shopping</a>
          </div>
        </div>
      </div>

      <div id="sidebar">
        <div id="section">
          <div>
            <div>
              <h2>Shopping Information</h2>
              <ul>
                <li><a href="#">Shipping Policy <span></span></a></li>
                <li><a href="#">Return Policy <span></span></a></li>
                <li><a href="#">Payment Methods <span></span></a></li>
                <li><a href="#">FAQs <span></span></a></li>
                <li><a href="#">Contact Support <span></span></a></li>
              </ul>
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
          <p> Lorem ipsum dolor sit amet, cons ectetuer adepis cing, sed diam euis. <a class="more" href="#">Read
              More</a> </p>
        </li>
        <li> <img src="images/healthy-dog.jpg" width="240" height="186" alt="">
          <h2><a href="#">Keep them healthy</a></h2>
          <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonu mmy. <a class="more" href="#">Read
              More</a> </p>
        </li>
        <li>
          <h2><a href="#">Love...love...love...pets</a></h2>
          <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diameusim. <a class="more" href="#">Read
              More</a> </p>
          <img src="images/pet-lover.jpg" width="240" height="186" alt="">
        </li>
      </ul>
    </div>
    <div id="footnote">
      <div class="section">Copyright &copy; 2012 <a href="#">Company Name</a> All rights reserved | Website Template By
        <a target="_blank" href="http://www.freewebsitetemplates.com/">freewebsitetemplates.com</a>
      </div>
    </div>
  </div>

  <!-- Sử dụng JavaScript modules từ cart-service -->
  <script src="../cart-service/public/js/cartAPI.js"></script>
  <script src="../cart-service/public/js/cartManager.js"></script>
  <script src="../cart-service/public/js/cartUI.js"></script>
</body>

</html>