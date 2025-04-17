<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart | PetGuide</title>
<meta charset="iso-8859-1">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/header.css" rel="stylesheet" type="text/css">
<!--[if IE 6]><link href="css/ie6.css" rel="stylesheet" type="text/css"><![endif]-->
<!--[if IE 7]><link href="css/ie7.css" rel="stylesheet" type="text/css"><![endif]-->
<style>
  .cart-container {
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    margin-bottom: 20px;
  }
  
  .cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }
  
  .cart-table th {
    background-color: #5c9d7e;
    color: white;
    text-align: left;
    padding: 10px;
  }
  
  .cart-table td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
  }
  
  .cart-table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
  }
  
  .quantity-control {
    display: flex;
    align-items: center;
  }
  
  .quantity-btn {
    background: #f0f0f0;
    border: none;
    width: 25px;
    height: 25px;
    cursor: pointer;
    font-weight: bold;
  }
  
  .quantity-input {
    width: 40px;
    text-align: center;
    margin: 0 5px;
    padding: 4px;
    border: 1px solid #ddd;
  }
  
  .remove-btn {
    background: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
  }
  
  .cart-summary {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
  }
  
  .cart-total {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    font-weight: bold;
  }
  
  .checkout-btn {
    background: #5c9d7e;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 15px;
    width: 100%;
    transition: background 0.3s;
  }
  
  .checkout-btn:hover {
    background: #4a7d62;
  }
  
  .continue-shopping {
    display: inline-block;
    margin-top: 15px;
    color: #5c9d7e;
    text-decoration: none;
  }
  
  .empty-cart {
    text-align: center;
    padding: 50px 0;
  }
  
  .empty-cart p {
    margin-bottom: 20px;
    color: #777;
  }
</style>
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
          <tbody>
            <tr>
              <td><img src="/api/placeholder/80/80" alt="Dog Food"></td>
              <td>
                <h4>Premium Dog Food</h4>
                <p>Organic chicken and vegetables, 5kg</p>
              </td>
              <td>$45.99</td>
              <td>
                <div class="quantity-control">
                  <button class="quantity-btn">-</button>
                  <input type="text" class="quantity-input" value="1">
                  <button class="quantity-btn">+</button>
                </div>
              </td>
              <td>$45.99</td>
              <td><button class="remove-btn">Remove</button></td>
            </tr>
            <tr>
              <td><img src="/api/placeholder/80/80" alt="Cat Toy"></td>
              <td>
                <h4>Interactive Cat Toy</h4>
                <p>Battery operated mouse with sound</p>
              </td>
              <td>$12.50</td>
              <td>
                <div class="quantity-control">
                  <button class="quantity-btn">-</button>
                  <input type="text" class="quantity-input" value="2">
                  <button class="quantity-btn">+</button>
                </div>
              </td>
              <td>$25.00</td>
              <td><button class="remove-btn">Remove</button></td>
            </tr>
            <tr>
              <td><img src="/api/placeholder/80/80" alt="Pet Bed"></td>
              <td>
                <h4>Comfortable Pet Bed</h4>
                <p>Medium size, washable cover</p>
              </td>
              <td>$35.00</td>
              <td>
                <div class="quantity-control">
                  <button class="quantity-btn">-</button>
                  <input type="text" class="quantity-input" value="1">
                  <button class="quantity-btn">+</button>
                </div>
              </td>
              <td>$35.00</td>
              <td><button class="remove-btn">Remove</button></td>
            </tr>
          </tbody>
        </table>
        
        <div class="cart-summary">
          <div class="cart-total">
            <span>Subtotal:</span>
            <span>$105.99</span>
          </div>
          <div class="cart-total">
            <span>Shipping:</span>
            <span>$5.00</span>
          </div>
          <div class="cart-total">
            <span>Total:</span>
            <span>$110.99</span>
          </div>
          
          <button class="checkout-btn">Proceed to Checkout</button>
          <a href="petmart.php" class="continue-shopping">Continue Shopping</a>
        </div>
        
        <!-- Giỏ hàng trống (ẩn mặc định) -->
        <div class="empty-cart" style="display: none;">
          <img src="/api/placeholder/150/150" alt="Empty Cart">
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
</body>
</html>