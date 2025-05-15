module.exports = {
    apps: [
      {
        name: 'product-service',
        script: './product-service/index.js',
        env: {
          PORT: 6000,
          DB_HOST: 'localhost',
          DB_USER: 'root',
          DB_PASSWORD: '082004',
          DB_DATABASE: 'pet_store',
        },
      },
      {
        name: 'cart-service',
        script: './cart-service/index.js',
        env: {
          PORT: 3002,
          DB_HOST: 'localhost',
          DB_USER: 'root',
          DB_PASSWORD: '082004',
          DB_NAME: 'cart_db',
        },
      },
      {
        name: 'order-service',
        script: './order-service/index.js',
        env: {
          PORT: 6003,
          DB_HOST: 'localhost',
          DB_USER: 'root',
          DB_PASSWORD: '082004',
          DB_DATABASE: 'order_store',
        },
      },
      {
        name: 'user-service',
        script: './user-service/index.js',
        env: {
          PORT: 4000,
          DB_HOST: 'localhost',
          DB_USER: 'root',
          DB_PASSWORD: '082004',
          DB_DATABASE: 'user_service',
        },
      },
      {
        name: 'api-gateway',
        script: './api-gateway/index.js',
        env: {
          PORT: 3000,
          NODE_ENV: 'production',
        },
      },
    ],
  };
  