const express = require('express');
const blogRoutes = require('./src/routes/blogRoutes');
const sequelize = require('./src/utils/db');
require('dotenv').config();

const app = express();
const PORT = process.env.PORT || 5000;

// Kết nối DB
sequelize.sync({ alter: true })
    .then(() => console.log('Database synchronized.'))
    .catch((err) => console.error('Error synchronizing database:', err));

// Middleware
app.use(express.json());
app.use('/images', express.static('public/images')); // Phục vụ ảnh trực tiếp
app.use('/blog-service', blogRoutes);

app.listen(PORT, () => {
    console.log(`Blog-service is running on http://localhost:${PORT}`);
});
