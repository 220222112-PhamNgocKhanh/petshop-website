module.exports = {
    apps: [
      {
        name: 'product-service',
        script: './product-service/index.js',
        env: {
          PORT: 6000,
          DB_HOST: 'localhost',
          DB_USER: 'root',
          DB_PASSWORD: '',
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
          DB_PASSWORD: '',
          DB_NAME: 'cart_db',
        },
      },
      {
        name: 'order-service',
        script: './order-service/index.js',
        env: {
          PORT: 4003,
          DB_HOST: 'localhost',
          DB_USER: 'root',
          DB_PASSWORD: '',
          DB_DATABASE: 'order_service',
        },
      },
      {
        name: 'user-service',
        script: './user-service/index.js',
        env: {
          PORT: 4000,
          DB_HOST: 'localhost',
          DB_USER: 'root',
          DB_PASSWORD: '',
          DB_DATABASE: 'user_service',
        },
      },
      {
        name: 'blog-service',
        script: './blog-service/index.js',
        env: {
          PORT: 5000,
          DB_HOST: 'localhost',
          DB_USER: 'root',
          DB_PASSWORD: '',
          DB_DATABASE: 'blog-service',
        },
      },
      {
        name: 'notification-service',
        script: './notification-service/index.js',
        env: {
          PORT: 3005,
          EMAIL_USER:"22022100@vnu.edu.vn",
          POSTMARK_API_KEY:"2a79cd20-879f-4e51-bb36-48ba42857cc5",
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
  