const jwt = require('jsonwebtoken');
const SECRET_KEY = 'petshop'; // giống user-service

function verifyToken(req, res, next) {
    const authHeader = req.headers['authorization'];
    if (!authHeader || !authHeader.startsWith('Bearer ')) {
        res.writeHead(401, { 'Content-Type': 'application/json' });
        return res.end(JSON.stringify({ message: 'Missing or invalid token' }));
    }

    const token = authHeader.split(' ')[1];

    try {
        const decoded = jwt.verify(token, SECRET_KEY);
        console.log('Decoded token:', decoded); // Log thông tin token
        req.user = decoded;
        next();
    } catch (err) {
        console.error('Token verification error:', err); // Log lỗi chi tiết
        res.writeHead(403, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Invalid or expired token' }));
    }
}

module.exports = verifyToken;
