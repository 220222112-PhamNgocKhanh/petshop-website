function showToast(message = 'Đã thêm vào giỏ hàng!') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');
  
    setTimeout(() => {
      toast.classList.remove('show');
    }, 2500);
  }

  
function addToCart(product, quantity = 1) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
  
    const existing = cart.find(item => item.id === product.id);
    if (existing) {
      existing.quantity += quantity;
    } else {
      product.quantity = quantity; // Thêm thuộc tính quantity vào sản phẩm
      cart.push(product);
    }
  
    localStorage.setItem('cart', JSON.stringify(cart));
    showToast(`Đã thêm ${quantity} sản phẩm "${product.name}" vào giỏ hàng!`);
  }
  
  
