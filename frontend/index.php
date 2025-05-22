<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pet Shop | Home</title>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/header.css" rel="stylesheet" type="text/css"> <!-- Liên kết file header.css -->
    <link href="css/footer.css" rel="stylesheet" type="text/css"> <!-- Liên kết file footer.css -->
    <link href="css/custom.css" rel="stylesheet" type="text/css"> <!-- Liên kết file custom.css -->
    <link href="css/home.css" rel="stylesheet" type="text/css"> <!-- Liên kết file home.css -->
    <link href="css/product-animations.css" rel="stylesheet" type="text/css">
    <!-- Liên kết file product-animations.css -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> <!-- AOS Animation library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Font Awesome -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive meta tag -->
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- Body -->
    <div id="body"> <!-- Hero Banner with Modern Design -->
        <div class="hero-banner">
            <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                <h1>Cửa hàng thú cưng<br><span class="highlight">Pet Shop</span></h1>
                <p>Chăm sóc toàn diện cho thú cưng của bạn với các sản phẩm chất lượng cao</p>                <div class="hero-buttons">
                    <a href="petmart.php?reset=true" class="btn primary-btn">Mua sắm ngay</a>
                    <a href="about.php" class="btn outline-btn">Tìm hiểu thêm</a>
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                <img src="images/pet-lover2.jpg" alt="Pet Shop - Chăm sóc thú cưng">
            </div>
        </div>

        <div id="content">
            <!-- Latest Products Section with Modern Design -->
            <div class="content products-section">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-title">
                        <h2>Sản phẩm mới nhất</h2>
                        <p>Khám phá các sản phẩm mới và hấp dẫn nhất cho thú cưng của bạn</p>
                    </div>                    <div class="section-actions">
                        <a href="petmart.php?reset=true" class="view-all">Xem tất cả <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="latest-products">
                    <div class="products-grid" id="latestProducts">
                        <!-- Products will be loaded here with animation -->
                    </div>
                </div>
            </div>

            <!-- Popular Products with Spotlight Layout -->
            <div class="content popular-products-section">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-title">
                        <h2>Sản phẩm nổi bật</h2>
                        <p>Những sản phẩm bán chạy và được yêu thích nhất</p>
                    </div>
                    <div class="section-actions">

                    </div>
                </div>

                <div class="spotlight-products">
                    <div class="spotlight-main" data-aos="fade-right">
                        <div class="spotlight-card">
                            <div class="spotlight-image">
                                <img src="images/pet-food.jpg" alt="Premium Pet Food">
                                <div class="spotlight-overlay">
                                    <h3>Thức ăn cao cấp</h3>
                                    <p>Sản phẩm dinh dưỡng tốt nhất cho thú cưng của bạn</p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="spotlight-grid" data-aos="fade-left">
                        <div class="spotlight-card small">
                            <div class="spotlight-image">
                                <img src="images/Accessories.jpg" alt="Pet Toys">
                                <div class="spotlight-overlay">
                                    <h3>Pet Accessories</h3>
                                    <a href="petmart.php?category=toys" class="btn outline-btn small">Xem ngay</a>
                                </div>
                            </div>
                        </div>

                        <div class="spotlight-card small">
                            <div class="spotlight-image">
                                <img src="images/Gromming.jpg" alt="Pet Accessories">
                                <div class="spotlight-overlay">
                                    <h3>Gromming</h3>
                                    <a href="petmart.php?category=accessories" class="btn outline-btn small">Xem
                                        ngay</a>
                                </div>
                            </div>
                        </div>

                        <div class="spotlight-card small">
                            <div class="spotlight-image">
                                <img src="images/Health.jpg" alt="Pet Healthcare">
                                <div class="spotlight-overlay">
                                    <h3>Health Center</h3>
                                    <a href="petmart.php?category=health" class="btn outline-btn small">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="spotlight-card small">
                            <div class="spotlight-image">
                                <img src="images/Food.jpg" alt="Pet Grooming">
                                <div class="spotlight-overlay">
                                    <h3>Food Area</h3>

                                    <a href="petmart.php?category=dog-food" class="btn outline-btn small">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Newsletter Section -->
            <div class="newsletter-section" data-aos="fade-up">
                <div class="newsletter-container">
                    <div class="newsletter-content">
                        <h2><i class="fas fa-envelope"></i> Đăng ký nhận tin</h2>
                        <p>Nhận thông báo về các sản phẩm mới, khuyến mãi đặc biệt và hướng dẫn chăm sóc thú cưng.</p>
                        <form class="newsletter-form">
                            <input type="email" placeholder="Địa chỉ email của bạn" required>
                            <button type="submit" class="subscribe-btn">Đăng ký</button>
                        </form>
                    </div>
                    <div class="newsletter-image">
                        <img src="images/newsletter-pet.jpg" alt="Đăng ký nhận thông tin">
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div> <!-- Footer -->
    <div id="footer">
        <div class="section footer-main">
            <div class="footer-column">
                <h3>PET SHOP</h3>
                <p>Cửa hàng thú cưng hàng đầu với các sản phẩm chất lượng cao dành cho thú cưng của bạn. Chúng tôi
                    cung cấp thực phẩm, phụ kiện và dịch vụ chăm sóc sức khỏe.</p>
                <div class="social-links">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-column">
                <h3>Liên kết nhanh</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="petmart.php">Petmart</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Categories</h3>
                <ul class="footer-links">
                    <li><a href="#" data-category="Dog Food">Food Area</a></li>
                    <li><a href="#" data-category="Deodorizers">Gromming</a></li>
                    <li><a href="#" data-category="Odor Control">Accessories</a></li>
                    <li><a href="#" data-category="Multivitamins">Health</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Contact Us</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Đường Pet, Quận 1, TP.HCM</li>
                    <li><i class="fas fa-phone"></i> +84 123 456 789</li>
                    <li><i class="fas fa-envelope"></i> info@petshop.com</li>
                    <li><i class="fas fa-clock"></i> Thứ 2-7: 8:00 - 20:00</li>
                </ul>
            </div>
        </div>

        <div id="footnote">
            <div class="section">
                <div class="copyright">
                    Copyright &copy; 2025 <a href="#">Pet Shop</a>. All rights reserved.
                </div>
                <div class="payment-methods">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-paypal"></i>
                    <i class="fab fa-cc-amex"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Cart Manager Script -->
    <script src="../cart-service/public/js/cartAPI.js"></script>
    <script src="../cart-service/public/js/cartManager.js"></script>

    <!-- Custom Scripts -->
    <script src="js/image-loader.js"></script>
    <script src="js/home.js"></script>

    <script src="../backend/product/category_count.js"></script>
    <script src="../backend/untils/renderProducts.js"></script>
    <script src="../backend/product/product_detail.js"></script>
    <script src="../backend/product/search_product.js"></script>





</body>

</html>