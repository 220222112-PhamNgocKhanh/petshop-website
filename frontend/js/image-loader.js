/**
 * Image loader script for Pet Shop website
 * Handles lazy loading and progressive loading of images
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize with a small delay to allow other scripts to load first
    setTimeout(initImageLoader, 100);
});

/**
 * Initialize the image loader
 */
function initImageLoader() {
    // Use Intersection Observer API for lazy loading
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.getAttribute('data-src');
                    
                    if (src) {
                        // Create a new image to preload
                        const tempImg = new Image();
                        
                        // When the image loads, apply it to the visible image
                        tempImg.onload = function() {
                            img.src = src;
                            img.classList.add('loaded');
                        };
                        
                        tempImg.onerror = function() {
                            // If loading fails, use default image
                            img.src = '../backend/image/default/default-product.jpg';
                            img.classList.add('loaded');
                            console.warn('Failed to load image:', src);
                        };
                        
                        tempImg.src = src;
                        img.removeAttribute('data-src');
                    }
                    
                    // Once loaded, no need to observe anymore
                    observer.unobserve(img);
                }
            });
        }, {
            // Options for the observer
            rootMargin: '50px 0px',
            threshold: 0.1
        });
        
        // Observe all images with data-src attribute
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    } else {
        // Fallback for browsers that don't support Intersection Observer
        loadImagesImmediately(document.querySelectorAll('img[data-src]'));
    }
    
    // Apply blur-up technique to all product images
    setupProgressiveLoading();
}

/**
 * Fallback for loading images immediately without lazy loading
 * @param {NodeList} images - Images to load
 */
function loadImagesImmediately(images) {
    images.forEach(img => {
        const src = img.getAttribute('data-src');
        if (src) {
            img.src = src;
            img.removeAttribute('data-src');
        }
    });
}

/**
 * Setup progressive loading effect for product images
 * Shows a low quality placeholder first, then fades in the full image
 */
function setupProgressiveLoading() {
    // Find all product image containers
    document.querySelectorAll('.product-image').forEach(container => {
        const img = container.querySelector('img');
        
        if (img && !img.classList.contains('progressive-setup')) {
            img.classList.add('progressive-setup');
            
            // Get the original source
            const origSrc = img.src;
            
            // If the image is already loaded (from cache), don't apply effect
            if (img.complete) {
                img.classList.add('loaded');
                return;
            }
            
            // Apply low quality placeholder if not already set
            if (!img.style.backgroundImage) {
                // Create a temporary canvas for a blurred placeholder
                const canvas = document.createElement('canvas');
                canvas.width = 30;  // Very small dimensions for the placeholder
                canvas.height = 20;
                const ctx = canvas.getContext('2d');
                
                // Fill with a light gray color as placeholder
                ctx.fillStyle = '#f0f0f0';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Use canvas as a placeholder
                const placeholderUrl = canvas.toDataURL('image/jpeg');
                img.style.backgroundImage = `url(${placeholderUrl})`;
                img.style.backgroundSize = 'cover';
                img.style.backgroundPosition = 'center';
            }
            
            // When the image loads, add loaded class to fade it in
            img.onload = function() {
                img.classList.add('loaded');
            };
            
            // Handle image load errors
            img.onerror = function() {
                img.src = '../backend/image/default/default-product.jpg';
                img.classList.add('loaded');
                console.warn('Failed to load image:', origSrc);
            };
        }
    });
}

// Add CSS rules dynamically for progressive loading
function addProgressiveLoadingStyles() {
    const style = document.createElement('style');
    style.textContent = `
    .product-image img {
        opacity: 0;
        transition: opacity 0.5s;
    }
    
    .product-image img.loaded {
        opacity: 1;
    }
    `;
    document.head.appendChild(style);
}

// Add styles as soon as possible
addProgressiveLoadingStyles();
