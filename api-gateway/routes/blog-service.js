const requestHandler = require('../utils/requestHandler');

const blogServiceRoutes = (req, res, url, method) => {
    if (method === 'POST' && url === '/blog-service/posts') {
        return requestHandler(req, res, 'http://localhost:5000/blog-service/posts'); // URL của blog-service
    } else if (url === '/blog-service/posts' && method === 'GET') {
        return requestHandler(req, res, 'http://localhost:5000/blog-service/posts');
     }
     else if(method === 'GET' && url.startsWith('/blog-service/posts/')) {
        const postId = url.split('/')[3]; // Lấy ID bài viết từ URL
        return requestHandler(req, res, `http://localhost:5000/blog-service/posts/${postId}`); 
     } else if (method === 'PUT' && url.startsWith('/blog-service/posts/')) {
        const postId = url.split('/')[3]; // Lấy ID bài viết từ URL
        return requestHandler(req, res, `http://localhost:5000/blog-service/posts/${postId}`); 
     }
     else if (method === 'DELETE' && url.startsWith('/blog-service/posts/')) {
        const postId = url.split('/')[3]; // Lấy ID bài viết từ URL
        return requestHandler(req, res, `http://localhost:5000/blog-service/posts/${postId}`); 
     }
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Blog service route not found' }));
};

module.exports = blogServiceRoutes;