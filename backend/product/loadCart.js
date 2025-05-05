function renderCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartBody = document.getElementById('cart-body');
    const emptyCart = document.querySelector('.empty-cart');
    const cartTable = document.querySelector('.cart-table');
  
    if (!cartBody || !emptyCart || !cartTable) return;
  
    if (cart.length === 0) {
      cartBody.innerHTML = '';
      emptyCart.style.display = 'block';
      cartTable.style.display = 'none';
      return;
    }
  
    emptyCart.style.display = 'none';
    cartTable.style.display = 'table';
    cartBody.innerHTML = '';
  
    cart.forEach(item => {
      cartBody.innerHTML += `
        <tr class="cart-item">
          <td class="cart-item-image">
            <img src="../backend/image/${item.category}/${item.image}" width="50" alt="${item.name}">
          </td>
          <td class="cart-item-name">${item.name}</td>
          <td class="cart-item-price">${Number(item.price).toLocaleString('en-US', { style: 'currency', currency: 'USD' })}</td>
          <td class="cart-item-quantity">
            <input type="number" class="quantity-input" data-id="${item.id}" value="${item.quantity}" min="1">
          </td>
          <td class="cart-item-total">${(item.price * item.quantity).toLocaleString('en-US', { style: 'currency', currency: 'USD' })}</td>
          <td class="cart-item-action">
            <button class="remove-btn" onclick="removeFromCart(${item.id})">Remove</button>
          </td>
        </tr>
      `;
    });
  
    // Cập nhật tổng giá
    let subtotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    let shipping = 5;
    let total = subtotal + shipping;
  
    document.getElementById('subtotal-amount').textContent = subtotal.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    document.getElementById('shipping-amount').textContent = shipping.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    document.getElementById('total-amount').textContent = total.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
  
    // Lắng nghe thay đổi số lượng
    document.querySelectorAll('.quantity-input').forEach(input => {
      input.addEventListener('change', (e) => {
        const newQuantity = parseInt(e.target.value);
        const productId = parseInt(e.target.getAttribute('data-id'));
  
        if (newQuantity < 1) return;
  
        const product = cart.find(item => item.id === productId);
        if (product) {
          product.quantity = newQuantity;
          localStorage.setItem('cart', JSON.stringify(cart));
          renderCart(); // Cập nhật lại
        }
      });
    });
  }
  function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
  }
  
  // Load cart khi trang load
  window.addEventListener('DOMContentLoaded', renderCart);