/**
 * Hàm để parse body của request
 * @param {Object} req - Request object
 * @param {Object} res - Response object
 * @param {Function} callback - Hàm callback để xử lý body đã parse
 */
const parseRequestBody = (req, res, callback) => {
    let body = '';

    req.on('data', (chunk) => {
        body += chunk.toString(); // Thu thập dữ liệu từ request
    });

    req.on('end', () => {
        try {
            const parsedBody = JSON.parse(body); // Parse dữ liệu JSON
            callback(parsedBody); // Gọi callback với body đã parse
        } catch (error) {
            res.writeHead(400, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Invalid JSON format' }));
        }
    });
};

module.exports = parseRequestBody;