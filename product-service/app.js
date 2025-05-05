const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
require('dotenv').config();
const productRoutes = require('./scr/routes/product.routes.js');

const app = express();
const PORT = process.env.PORT || 6000;

app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ error: 'Something went wrong!' });
});
app.use(cors());
app.use(bodyParser.json());

app.use('/products', productRoutes);

app.listen(PORT, () => {
    console.log(`Product Service running on port ${PORT}`);
});
