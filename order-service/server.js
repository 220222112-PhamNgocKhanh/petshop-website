const http = require('http');
const orderRouter = require('./routes/orderRoutes');

// Middleware xử lý CORS
const corsMiddleware = (req, res, next) => {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    if (req.method === 'OPTIONS') {
        res.writeHead(204);
        res.end();
        return;
    }

    next();
};

const server = http.createServer((req, res) => {
    corsMiddleware(req, res, () => {
        res.setHeader('Content-Type', 'application/json; charset=utf-8');
        orderRouter(req, res);
    });
});

server.listen(3001, () => {
    console.log('Order service running at http://localhost:3001');
});
