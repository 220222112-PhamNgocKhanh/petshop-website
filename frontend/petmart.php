<!DOCTYPE html>
<html>

<head>
  <title>Pet Shop | PetMart</title>
  <meta charset="iso-8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
  <!--[if IE 6]><link href="css/ie6.css" rel="stylesheet" type="text/css"><![endif]-->
  <!--[if IE 7]><link href="css/ie7.css" rel="stylesheet" type="text/css"><![endif]-->
  <link rel="stylesheet" href="css/petmart.css">
  <link rel="stylesheet" href="css/modal_style.css">
  <link href="css/header.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>


<body>
<?php include 'header.php'; ?>

  <div class="search-bar">
    <select id="categorySelect">
      <option value="all">All Categories</option>
      <option value="Dog Food">Dog Food</option>
      <option value="Cat Food">Cat Food</option>
      <option value="Bird Food">Bird Food</option>
      <option value="Fish Food">Fish Food</option>
      <option value="Small Pet Food">Small Pet Food</option>
      <option value="Large Pet Food">Large Pet Food</option>
      <option value="Odor Control">Odor Control</option>
      <option value="Liners">Liners</option>
      <option value="Scoops & Mats">Scoops & Mats</option>
      <option value="Collars">Collars</option>
      <option value="Harnesses">Harnesses</option>
      <option value="Leashes">Leashes</option>
      <option value="Multivitamins">Multivitamins</option>
      <option value="Dental Care">Dental Care</option>
      <option value="First Aid Kits">First Aid Kits</option>
      <option value="Eye & Ear Care">Eye & Ear Care</option>
      <option value="Hip & Joint Health">Hip & Joint Health</option>
      <option value="Brushes & Combs">Brushes & Combs</option>
      <option value="Deodorizers">Deodorizers</option>
      <option value="Cologne">Cologne</option>
      <option value="Ear & Eye Cleaners">Ear & Eye Cleaners</option>
      <option value="Nail Clippers">Nail Clippers</option>
      
    </select>
    <input type="text" id="search-input" placeholder="Tìm kiếm...">
    <button id="search-btn"><i class="fa fa-search"></i></button>
  </div>
  <div class="yellow-line"></div>
  <div id="body">
    <div id="content">

      

      <div class="main-content">
        <div class="product-categories">
          <div class="product-categories-header">
            <a href="">
              PRODUCT CATEGORIES
            </a>
          </div>
          <ul class="category-wrapper">
            <li>
              <div class="category-item">
                <a>Food Area</a>
              </div>
              <ul class="category-list">
                <li><a href="#" data-category="Dog Food">Dog Food</a></li>
                <li><a href="#" data-category="Cat Food">Cat Food</a></li>
                <li><a href="#" data-category="Bird Food">Bird Food</a></li>
                <li><a href="#" data-category="Fish Food">Fish Food</a></li>
                <li><a href="#" data-category="Small Pet Food">Small Pet Food</a></li>
                <li><a href="#" data-category="Large Pet Food">Large Pet Food</a></li>
              </ul>
            </li>
            <li>
              <div class="category-item">
                <a>Accessories</a>
              </div>
              <ul class="category-list">
                <li><a href="#" data-category="Odor Control">Odor Control</a></li>
                <li><a href="#" data-category="Liners">Liners</a></li>
                <li><a href="#" data-category="Scoops & Mats">Scoops & Mats</a></li>
                <li><a href="#" data-category="Collars">Collars</a></li>
                <li><a href="#" data-category="Harnesses">Harnesses</a></li>
                <li><a href="#" data-category="Leashes">Leashes</a></li>
              </ul>

            </li>

            <li>
              <div class="category-item">
                <a>Health Center</a>

              </div>
              <ul>
                <li><a href= "#" data-category="Multivitamins">Multivitamins</a></li>
                <li><a href= "#" data-category="Dental Care">Dental Care</a></li>
                <li><a href= "#" data-category="First Aid Kits">First Aid Kits</a></li>
                <li><a href= "#" data-category="Eye & Ear Care">Eye & Ear Care</a></li>
                <li><a href= "#" data-category="Hip & Joint Health">Hip & Joint Health</a></li>
              </ul>
            </li>

            <li>
              <div class="category-item">
                <a>Grooming</a>

              </div>
              <ul>
                <li><a href= "#" data-category="Brushes & Combs">Brushes & Combs</a></li>
                <li><a href= "#" data-category="Deodorizers">Deodorizers</a></li>
                <li><a href= "#" data-category="Cologne">Cologne</a></li>
                <li><a href= "#" data-category="Ear & Eye Cleaners">Ear & Eye Cleaners</a></li>
                <li><a href= "#" data-category="Nail Clippers">Nail Clippers</a></li>
              </ul>
            </li>
          </ul>
        </div>

        <div class="products">
          <!-- <div class="products-header"> -->

          <!-- </div> -->
          <div id="product-container" class="main-products">
            <!-- <div class="product-tags">
            <div class="product-img">
              <img src="images/good-food.jpg">
              <div class="overlay">
                <button class="buy-btn">
                  <div><a>BUY</a></div>
                </button>
              </div>
            </div>
            <h1>Special Dog Food</h1>
            <h2> 400.000 <span>₫</span></h2>
          </div> -->

          </div>
          <!-- </div> -->
        </div>
      </div>
    </div>
    <div id="toast" class="toast"></div>

    <script src="../cart-service/public/js/cartAPI.js"></script>
    <script src="../cart-service/public/js/cartManager.js"></script>
    <script src="../backend/product/category_count.js"></script>
    <script src="../backend/untils/renderProducts.js"></script>
    <script src="../backend/product/product_detail.js"></script>
    <script src="../backend/product/search_product.js"></script>

    <div class="featured">
      <ul>
        <li><a href="#"><img src="images/organic-and-chemical-free.jpg" width="300" height="90" alt=""></a></li>
        <li><a href="#"><img src="images/good-food.jpg" width="300" height="90" alt=""></a></li>
        <li class="last"><a href="#"><img src="images/pet-grooming.jpg" width="300" height="90" alt=""></a></li>
      </ul>
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
            <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonu mmy. <a class="more"
                href="#">Read More</a> </p>
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

      </div>
    </div>

    <!-- Modal -->
<div id="productModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div id="modal-body">
      <!-- Nội dung sản phẩm sẽ render tại đây -->
    </div>
  </div>
</div>

<script src = "../backend/product/modal_handler.js"></script>

</body>

</html>