const blogController = require('../controllers/blogController');

const blogRoutes = (req, res, pathname, method) => {
    if (pathname === '/blog-service/posts' && method === 'POST') {
        blogController.createPost(req, res);
    } else if (pathname === '/blog-service/posts' && method === 'GET') {
        blogController.getPosts(req, res);
    } else if (method === 'GET' && pathname.startsWith('/blog-service/posts/')) {
        blogController.getPostById(req, res);
    } else if (method === 'PUT' && pathname.startsWith('/blog-service/posts/')) {
        blogController.updatePost(req, res);
    } else if (method === 'DELETE' && pathname.startsWith('/blog-service/posts/')) {
        blogController.deletePost(req, res);
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Blog service route not found' }));
    }
};

module.exports = blogRoutes;