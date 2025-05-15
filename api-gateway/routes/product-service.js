const requestHandler = require('../utils/requestHandler');

const productServiceRoutes = (req, res, url, method) => {
    const parts = url.split('/').filter(Boolean);

    // Route: GET /product-service/products
    if (url === '/product-service/products' && method === 'GET') {
        requestHandler(req, res, 'http://localhost:6000/products');
    }

    // Route: GET /product-service/products/:id
    else if (parts[0] === 'product-service' && parts[1] === 'products' && parts.length === 3 && method === 'GET') {
        const id = parts[2];
        requestHandler(req, res, `http://localhost:6000/products/${id}`);
    }

    // Route: POST /product-service/products
    else if (url === '/product-service/products' && method === 'POST') {
        requestHandler(req, res, 'http://localhost:6000/products');
    }

    // Route: PUT /product-service/products/:id
    else if (parts[0] === 'product-service' && parts[1] === 'products' && parts.length === 3 && method === 'PUT') {
        const id = parts[2];
        requestHandler(req, res, `http://localhost:6000/products/${id}`);
    }

    // Route: DELETE /product-service/products/:id
    else if (parts[0] === 'product-service' && parts[1] === 'products' && parts.length === 3 && method === 'DELETE') {
        const id = parts[2];
        requestHandler(req, res, `http://localhost:6000/products/${id}`);
    }

    // Route: GET /product-service/products/search/:name
    else if (parts[0] === 'product-service' && parts[1] === 'products' && parts[2] === 'search' && parts.length === 4 && method === 'GET') {
        const name = parts[3];
        requestHandler(req, res, `http://localhost:6000/products/search/${name}`);
    }

    // Route: GET /product-service/products/category/:categoryId
    else if (parts[0] === 'product-service' && parts[1] === 'products' && parts[2] === 'category' && parts.length === 4 && method === 'GET') {
        const categoryId = parts[3];
        requestHandler(req, res, `http://localhost:6000/products/category/${categoryId}`);
    }
    else if (parts[0] === 'product-service' && parts[1] === 'products' && parts[2] === 'searchbyname' && parts.length === 4 && method === 'GET') {
        const name = parts[3];
        requestHandler(req, res, `http://localhost:6000/products/searchbyname/${name}`);
    }
    else if (parts[0] === 'product-service' && parts[1] === 'products' && parts[2] === 'search-category' && parts.length === 5 && method === 'GET') {
        const category = parts[3];
        const keyword = parts[4];
        requestHandler(req, res, `http://localhost:6000/products/search-category/${category}/${keyword}`);
    }
    else if(parts[0] === 'product-service' && parts[1] === 'products' && parts[2] === 'upload' && method === 'POST') {
        requestHandler(req, res, `http://localhost:6000/products/upload`);
        
    }
    else if(parts[0] === 'product-service' && parts[1] === 'products' && parts[2] === 'upload' && parts.length === 4 && method === 'PUT') {
        const id = parts[3];
        requestHandler(req, res, `http://localhost:6000/products/upload/${id}`);
    }


    // Nếu không khớp bất kỳ route nào ở trên
    else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Product service route not found' }));
    }
};

module.exports = productServiceRoutes;
