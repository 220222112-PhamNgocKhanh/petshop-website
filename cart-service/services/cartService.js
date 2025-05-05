const CartItem = require('../models/cartItem');

// Get cart for a user
exports.getCart = async (userId) => {
  const items = await CartItem.findAll({
    where: { userId },
    attributes: ['productId', 'quantity']
  });
  return items;
};

// Add to cart
exports.addToCart = async (userId, productId, quantity) => {
  const [item, created] = await CartItem.findOrCreate({
    where: { userId, productId },
    defaults: { quantity }
  });

  if (!created) {
    item.quantity += quantity;
    await item.save();
  }

  return exports.getCart(userId);
};

// Update quantity
exports.updateCartItem = async (userId, productId, quantity) => {
  await CartItem.update(
    { quantity },
    { where: { userId, productId } }
  );
  return exports.getCart(userId);
};

// Remove item
exports.removeFromCart = async (userId, productId) => {
  await CartItem.destroy({ where: { userId, productId } });
  return exports.getCart(userId);
};
