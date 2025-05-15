<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pet Shop | Home</title>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/header.css" rel="stylesheet" type="text/css"> <!-- Liên kết file header.css -->
    <link href="css/footer.css" rel="stylesheet" type="text/css"> <!-- Liên kết file footer.css -->
    <link href="css/custom.css" rel="stylesheet" type="text/css"> <!-- Liên kết file custom.css -->
</head>

<body>
<?php include 'header.php'; ?>

    <!-- Body -->
    <div id="body">
        <div class="banner">&nbsp;</div>
        <div id="content">
            <div class="content">
                <h2>Sản phẩm mới nhất</h2>
                <div class="latest-products">
                    <div class="products-grid" id="latestProducts">
                        <!-- Products will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div id="footer">
        <div class="section">
            
        </div>
        <div id="footnote">
            <div class="section">
                Copyright &copy; 2025 <a href="#">Pet Shop</a>. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const response = await fetch('http://localhost:3000/product-service/products/latest');
                if (response.ok) {
                    const products = await response.json();
                    const productsContainer = document.getElementById('latestProducts');
                    
                    products.forEach(product => {
                        const productCard = document.createElement('div');
                        productCard.className = 'product-card';
                        productCard.innerHTML = `
                            <div class="product-image">
                                <img src="${product.image || 'images/default-product.jpg'}" alt="${product.name}">
                            </div>
                            <div class="product-info">
                                <h3>${product.name}</h3>
                                <p class="price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</p>
                                <p class="description">${product.description || ''}</p>
                                <button class="add-to-cart" onclick="addToCart(${product.id})">Thêm vào giỏ</button>
                            </div>
                        `;
                        productsContainer.appendChild(productCard);
                    });
                }
            } catch (error) {
                console.error('Error loading latest products:', error);
            }
        });

        function addToCart(productId) {
            // Implement add to cart functionality
            console.log('Adding product to cart:', productId);
        }
    </script>
</body>

</html>