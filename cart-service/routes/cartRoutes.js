const express = require('express');
const router = express.Router();
const cartService = require('../services/cartService');

// Get cart
router.get('/:userId', async (req, res) => {
  try {
    const cart = await cartService.getCart(req.params.userId);
    res.json(cart);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Add item
router.post('/:userId', async (req, res) => {
  try {
    const { productId, quantity } = req.body;
    const cart = await cartService.addToCart(req.params.userId, productId, quantity);
    res.json(cart);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Update quantity
router.put('/:userId', async (req, res) => {
  try {
    const { productId, quantity } = req.body;
    const cart = await cartService.updateCartItem(req.params.userId, productId, quantity);
    res.json(cart);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Remove item
router.delete('/:userId/:productId', async (req, res) => {
  try {
    const cart = await cartService.removeFromCart(req.params.userId, req.params.productId);
    res.json(cart);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
