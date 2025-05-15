const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
require('dotenv').config();
const productRoutes = require('./scr/routes/product.routes.js');

const app = express();
const PORT = process.env.PORT || 6000;

// Middleware
app.use(cors());

// Cấu hình body-parser cho JSON
app.use(bodyParser.json({ limit: '10mb' }));

// Cấu hình body-parser cho form data
app.use(bodyParser.urlencoded({ 
  extended: true, 
  limit: '10mb'
}));

// Log middleware để debug request
app.use((req, res, next) => {
  console.log(`${req.method} ${req.url}`);
  console.log('Headers:', req.headers);
  console.log('Body:', req.body);
  next();
});

// Routes
app.use('/products', productRoutes);

// Error handling middleware - phải đặt sau tất cả routes
app.use((err, req, res, next) => {
    console.error('Global error handler caught:', err);
    res.status(500).json({ error: err.message || 'Something went wrong!' });
});

app.listen(PORT, () => {
    console.log(`Product Service running on port ${PORT}`);
});
