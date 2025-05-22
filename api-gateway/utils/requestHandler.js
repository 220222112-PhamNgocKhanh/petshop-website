const http = require('http');

const requestHandler = (req, res, serviceUrl) => {
    const serviceUrlObj = new URL(serviceUrl);

    const options = {
        hostname: serviceUrlObj.hostname,
        port: serviceUrlObj.port,
        path: serviceUrlObj.pathname + serviceUrlObj.search, // ✅ giữ cả query string
        method: req.method,
        headers: req.headers,
    };
    

    const proxy = http.request(options, (serviceRes) => {
        let data = '';

        serviceRes.on('data', (chunk) => {
            data += chunk;
        });

        serviceRes.on('end', () => {
            if (!res.headersSent) {
                res.writeHead(serviceRes.statusCode, serviceRes.headers);
                res.end(data);
            }
        });
    });

    proxy.on('error', (err) => {
        if (!res.headersSent) {
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Internal Server Error', error: err.message }));
        }
    });

    req.on('error', (err) => {
        if (!res.headersSent) {
            res.writeHead(500, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ message: 'Request error', error: err.message }));
        }
    });

    if (['POST', 'PUT', 'PATCH', 'DELETE'].includes(req.method)) {
        req.pipe(proxy);
    } else {
        proxy.end();
    }
};

module.exports = requestHandler;
