/**
 * Home.js - Specialized JavaScript for the Pet Shop home page
 * Handles loading featured products and implementing modern UI interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS library for scroll animations
    AOS.init({
        duration: 800,
        once: false,
        mirror: true
    });

    // Load latest products with nice animation
    loadLatestProducts();
    
    // Add parallax effect to spotlight products
    setupSpotlightEffects();
    
    // Handle newsletter subscription form
    setupNewsletterForm();
    
    // Add smooth scrolling for navigation links
    setupSmoothScrolling();
    
    // Xử lý các liên kết danh mục
    setupCategoryLinks();
});

/**
 * Load and display the latest products with animations
 */
function loadLatestProducts() {
    const productsContainer = document.getElementById('latestProducts');
    
    // Show loading state
    productsContainer.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i></div>';
    
    // Fetch latest products from API
    fetch('http://localhost:3000/product-service/products/latest')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Clear loading state
            productsContainer.innerHTML = '';
            
            // Check if products exist
            if (!data.products || data.products.length === 0) {
                productsContainer.innerHTML = '<p class="no-products">Chưa có sản phẩm nào.</p>';
                return;
            }
            
            // Get a maximum of 8 products for the homepage
            const products = data.products.slice(0, 8);
            
            // Render each product with staggered animation
            products.forEach((product, index) => {
                // Create product card with modern design
                const productCard = createProductCard(product, index);
                productsContainer.appendChild(productCard);
            });
            
            // Add event listeners for product actions
            setupProductActions();
        })
        .catch(error => {
            console.error('Error loading latest products:', error);
            productsContainer.innerHTML = '<p class="error-message">Không thể tải sản phẩm. Vui lòng thử lại sau.</p>';
        });
}

/**
 * Create a product card element with modern UI
 * @param {Object} product - The product data
 * @param {Number} index - Index for staggered animation 
 * @returns {HTMLElement} The product card element
 */
function createProductCard(product, index) {
    // Create main product card div
    const card = document.createElement('div');
    card.className = 'product-card';
    card.setAttribute('data-aos', 'fade-up');
    card.setAttribute('data-aos-delay', (index * 100).toString());
    card.setAttribute('data-product-id', product.id);
    
    // Calculate rating stars
    const rating = product.rating || Math.floor(Math.random() * 5) + 1; // Random rating if none
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            stars += '<i class="fas fa-star"></i>';
        } else {
            stars += '<i class="far fa-star"></i>';
        }
    }
    
    // Calculate if product is new (added within last 30 days)
    const isNew = product.createdAt ? 
        (new Date() - new Date(product.createdAt)) / (1000 * 60 * 60 * 24) < 30 : 
        Math.random() > 0.7; // Random for demo if no date
    
    // Calculate if product has a discount
    const hasDiscount = product.discount > 0;
    const discountAmount = hasDiscount ? product.discount : (Math.random() > 0.7 ? Math.floor(Math.random() * 30) + 10 : 0);
    
    // Format price
    const originalPrice = Number(product.price).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    let discountPrice = '';
    if (hasDiscount) {
        const discountedValue = product.price * (1 - (discountAmount / 100));
        discountPrice = Number(discountedValue).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    }
    
    // Product image path with fallback
    const imagePath = product.image ? 
        `../backend/image/${product.category}/${product.image}` : 
        '../backend/image/default/default-product.jpg';
    
    // Build card HTML structure
    card.innerHTML = `
        <div class="product-image">
            <img src="${imagePath}" alt="${product.name}" onerror="this.src='../backend/image/default/default-product.jpg';">
            
            <div class="product-tags">
                ${isNew ? '<span class="tag new-tag">Mới</span>' : ''}
                ${hasDiscount ? '<span class="tag discount-tag">-' + discountAmount + '%</span>' : ''}
            </div>
            
            <div class="product-actions">
                
                
            </div>
        </div>
        
        <div class="product-info">
            <div class="rating">
                ${stars}
            </div>
            
            <h3><a href="petmart.php?id=${product.id}">${product.name}</a></h3>
            
            <div class="description">
                ${product.description ? product.description.substring(0, 65) + '...' : 'Sản phẩm chất lượng cao cho thú cưng'}
            </div>
            
            <div class="price">
                ${hasDiscount ? `<span class="original-price">${originalPrice}</span> ${discountPrice}` : originalPrice}
            </div>
            
            <button class="add-to-cart" data-id="${product.id}">
                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
            </button>
        </div>
    `;
    
    return card;
}

/**
 * Set up event listeners for all product action buttons
 */
function setupProductActions() {
    // Add event listeners for add-to-cart buttons
    document.querySelectorAll('.product-card .add-to-cart, .product-card .cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.id || this.closest('.product-card').dataset.productId;
            
            // Show visual feedback
            const feedbackEl = document.createElement('div');
            feedbackEl.className = 'add-to-cart-feedback';
            feedbackEl.innerHTML = '<i class="fas fa-check"></i> Đã thêm vào giỏ hàng';
            document.body.appendChild(feedbackEl);
            
            // Remove the feedback element after animation
            setTimeout(() => {
                feedbackEl.classList.add('fade-out');
                setTimeout(() => {
                    document.body.removeChild(feedbackEl);
                }, 500);
            }, 1500);
            
            // Call CartManager if available
            if (typeof CartManager !== 'undefined' && CartManager.addToCart) {
                fetch(`http://localhost:3000/product-service/products/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.product && data.product.amount > 0) {
                            CartManager.addToCart(data.product, 1);
                            
                            // Update cart count if function available
                            if (typeof window.updateCartCount === 'function') {
                                setTimeout(() => window.updateCartCount(), 100);
                            }
                        } else {
                            showNotification('Sản phẩm đã hết hàng', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching product details:', error);
                        showNotification('Không thể thêm sản phẩm vào giỏ hàng', 'error');
                    });
            } else {
                console.warn('CartManager not available');
                // Fallback to direct fetch if CartManager is not available
                addToCartFallback(productId);
            }
        });
    });
    
    // Add event listeners for view detail buttons
    document.querySelectorAll('.product-card .view-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            window.location.href = `petmart.php?id=${productId}`;
        });
    });
    
    // Add event listeners for favorite buttons
    document.querySelectorAll('.product-card .favorite-btn').forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('active');
            const isFavorite = this.classList.contains('active');
            
            if (isFavorite) {
                this.innerHTML = '<i class="fas fa-heart"></i>';
                showNotification('Đã thêm vào sản phẩm yêu thích', 'success');
            } else {
                this.innerHTML = '<i class="far fa-heart"></i>';
                showNotification('Đã xóa khỏi sản phẩm yêu thích', 'info');
            }
            
            // TODO: Implement favorite product API call
        });
    });
}

/**
 * Fallback function to add product to cart if CartManager is not available
 */
function addToCartFallback(productId) {
    // Implement a basic add to cart API call
    fetch(`http://localhost:3000/cart-service/cart/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            productId: productId,
            quantity: 1
        }),
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Đã thêm sản phẩm vào giỏ hàng', 'success');
        } else {
            showNotification(data.message || 'Không thể thêm vào giỏ hàng', 'error');
        }
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
        showNotification('Không thể kết nối đến server', 'error');
    });
}

/**
 * Show notification popup
 * @param {String} message - The message to display
 * @param {String} type - The notification type (success, error, info)
 */
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    const icon = type === 'success' ? 'fas fa-check-circle' : 
                 type === 'error' ? 'fas fa-exclamation-circle' : 
                 'fas fa-info-circle';
    
    notification.innerHTML = `
        <i class="${icon}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Show the notification
    setTimeout(() => {
        notification.classList.add('show');
        
        // Hide and remove the notification after delay
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }, 10);
}

/**
 * Set up the newsletter subscription form
 */
function setupNewsletterForm() {
    const form = document.querySelector('.newsletter-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value.trim();
            
            if (!email || !isValidEmail(email)) {
                showNotification('Vui lòng nhập địa chỉ email hợp lệ', 'error');
                return;
            }
            
            // Simulate API call for newsletter subscription
            // TODO: Replace with actual API call
            setTimeout(() => {
                showNotification('Cảm ơn bạn đã đăng ký nhận tin!', 'success');
                emailInput.value = '';
            }, 500);
        });
    }
}

/**
 * Validate email format
 * @param {String} email - The email to validate
 * @returns {Boolean} Whether the email is valid
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Set up smooth scrolling for navigation links
 */
function setupSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Nếu href chỉ là "#" thì không làm gì cả
            if (href === "#") {
                e.preventDefault();
                return;
            }
            
            // Chỉ tìm kiếm phần tử nếu href có giá trị cụ thể như "#section1"
            if (href.length > 1) {
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    
                    window.scrollTo({
                        top: target.offsetTop - 80, // Offset for header
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
}

/**
 * Add parallax hover effect to spotlight products
 */
function setupSpotlightEffects() {
    const spotlightCards = document.querySelectorAll('.spotlight-card');
    
    spotlightCards.forEach(card => {
        const image = card.querySelector('.spotlight-image img');
        const overlay = card.querySelector('.spotlight-overlay');
        
        // Only add effect on desktop devices
        if (window.innerWidth > 1024) {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Calculate percentage position
                const xPercent = (x / rect.width) * 100;
                const yPercent = (y / rect.height) * 100;
                
                // Apply subtle transform to image
                image.style.transform = `translate(${(xPercent - 50) * -0.05}px, ${(yPercent - 50) * -0.05}px) scale(1.1)`;
                
                // Apply subtle text shadow based on mouse position
                const shadowX = (xPercent - 50) * 0.02;
                const shadowY = (yPercent - 50) * 0.02;
                const titles = overlay.querySelectorAll('h3');
                if (titles.length > 0) {
                    titles.forEach(title => {
                        title.style.textShadow = `${shadowX}px ${shadowY}px 10px rgba(0,0,0,0.5)`;
                    });
                }
            });
            
            card.addEventListener('mouseleave', () => {
                image.style.transform = '';
                const titles = overlay.querySelectorAll('h3');
                if (titles.length > 0) {
                    titles.forEach(title => {
                        title.style.textShadow = '';
                    });
                }
            });       
        
        }
    });
}

/**
 * Xử lý các liên kết danh mục trong footer
 */
function setupCategoryLinks() {
    // Xử lý các liên kết danh mục trong footer
    document.querySelectorAll('.footer-links a[data-category]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const category = this.getAttribute('data-category');
            if (category) {
                console.log(`Footer category link clicked: ${category}`);
                
                // Lưu danh mục đã chọn vào localStorage
                localStorage.removeItem('searchKeyword');
                localStorage.setItem('selectedCategory', category);
                
                // Bổ sung thêm điều này để đảm bảo danh mục được chọn đúng khi load trang mới
                localStorage.setItem('forceSelectCategory', 'true');
                
                console.log(`Stored category in localStorage: ${category}`);
                
                // Chuyển hướng đến trang petmart
                window.location.href = 'petmart.php';
            }
        });
    });
}