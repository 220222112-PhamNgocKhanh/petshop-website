// src/utils/parseRequestBody.js

function parseRequestBody(req, res, callback) {
    let body = '';

    req.on('data', chunk => {
        body += chunk.toString();
    });

    req.on('end', () => {
        try {
            const parsed = JSON.parse(body);

            if (typeof callback !== 'function') {
                console.error('❌ Callback is not a function');
                res.writeHead(500, { 'Content-Type': 'application/json' });
                return res.end(JSON.stringify({ message: 'Internal Server Error: invalid callback' }));
            }

            callback(parsed);
        } catch (err) {
            console.error('❌ JSON parse error:', err);
            res.writeHead(400, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Invalid JSON format' }));
        }
    });

    req.on('error', (err) => {
        console.error('❌ Request error:', err);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Request error' }));
    });
}

module.exports = parseRequestBody;
