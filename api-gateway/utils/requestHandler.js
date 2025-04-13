const http = require('http');

const requestHandler = (req, res, serviceUrl) => {
    const serviceUrlObj = new URL(serviceUrl);

    const options = {
        hostname: serviceUrlObj.hostname,
        port: serviceUrlObj.port,
        path: serviceUrlObj.pathname,
        method: req.method,
        headers: req.headers,
    };

    const proxy = http.request(options, (serviceRes) => {
        let data = '';

        serviceRes.on('data', (chunk) => {
            data += chunk;
        });

        serviceRes.on('end', () => {
            res.writeHead(serviceRes.statusCode, serviceRes.headers);
            res.end(data);
        });
    });

    proxy.on('error', (err) => {
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Internal Server Error', error: err.message }));
    });

    // Gửi body cho tất cả các phương thức có thể có body
    if (['POST', 'PUT', 'PATCH', 'DELETE'].includes(req.method)) {
        req.pipe(proxy);
    } else {
        proxy.end();
    }

};

module.exports = requestHandler;