const http = require('http');
const url = require('url');
const blogRoutes = require('./src/routes/blogRoutes');
const sequelize = require('./src/utils/db');
require('dotenv').config();

sequelize.sync({ alter: true })
    .then(() => console.log('Database synchronized.'))
    .catch((err) => console.error('Error synchronizing database:', err));

const server = http.createServer((req, res) => {
    const parsedUrl = url.parse(req.url, true);
    const method = req.method;
    const pathname = parsedUrl.pathname;

    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    if (method === 'OPTIONS') {
        res.writeHead(204);
        res.end();
        return;
    }

    if (pathname.startsWith('/blog-service')) {
        blogRoutes(req, res, pathname, method);
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Route not found' }));
    }
});

const PORT = process.env.PORT || 5000;
server.listen(PORT, () => {
    console.log(`Blog-service is running on http://localhost:${PORT}`);
});