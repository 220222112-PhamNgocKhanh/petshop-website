const express = require('express');
const authRoutes = require('../src/routes/authRoutes');
require('dotenv').config();

const app = express();
app.use(express.json());

// Định tuyến
app.use('/auth', authRoutes);

const PORT = process.env.PORT || 4000;
app.listen(PORT, () => {
    console.log(`User-service is running on http://localhost:${PORT}`);
});