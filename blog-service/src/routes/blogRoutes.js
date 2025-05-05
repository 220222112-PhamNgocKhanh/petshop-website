const blogController = require('../controllers/blogController');

const blogRoutes = (req, res, pathname, method) => {
    // Lấy tất cả bài viết
    if (pathname === '/blog-service/posts' && method === 'GET') {
        blogController.getPosts(req, res);
    }
    // Tạo bài viết mới
    else if (pathname === '/blog-service/posts' && method === 'POST') {
        blogController.createPost(req, res);
    }
    // Lấy bài viết theo ID
    else if (method === 'GET' && pathname.match(/^\/blog-service\/posts\/[\w-]+$/)) {
        const postId = pathname.split('/').pop();
        req.params = { id: postId };
        blogController.getPostById(req, res);
    }
    // Cập nhật bài viết
    else if (method === 'PUT' && pathname.match(/^\/blog-service\/posts\/[\w-]+$/)) {
        const postId = pathname.split('/').pop();
        req.params = { id: postId };
        blogController.updatePost(req, res);
    }
    // Xóa bài viết
    else if (method === 'DELETE' && pathname.match(/^\/blog-service\/posts\/[\w-]+$/)) {
        const postId = pathname.split('/').pop();
        req.params = { id: postId };
        blogController.deletePost(req, res);
    }
    // Route không tồn tại
    else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ 
            success: false,
            message: 'Blog service route not found' 
        }));
    }
};

module.exports = blogRoutes;