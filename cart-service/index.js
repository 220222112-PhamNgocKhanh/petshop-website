const express = require('express');
const dotenv = require('dotenv');
const sequelize = require('./db');
const cartRoutes = require('./routes/cartRoutes');

dotenv.config();
const app = express();
app.use(express.json());

sequelize.sync({ force: false }).then(() => {
    console.log(" Database synced");
  }).catch(err => {
    console.error(" DB Sync Error:", err);
  });
  
  

// Route prefix
app.use('/cart-service', cartRoutes);  // API Gateway sẽ gọi đến /cart/...

// Start server
const PORT = process.env.PORT || 3002;
app.listen(PORT, () => {
  console.log(` Cart Service running on port ${PORT}`);
});
