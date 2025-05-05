<!DOCTYPE html>
<html>
<head>
    <title>Pet Shop | Blog</title>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/header.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link href="css/blog.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!--[if IE 6]><link href="css/ie6.css" rel="stylesheet" type="text/css"><![endif]-->
    <!--[if IE 7]><link href="css/ie7.css" rel="stylesheet" type="text/css"><![endif]-->
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="blog-container">
        <div class="blog-header">
            <h1>Blog Thú Cưng</h1>
            <p>Khám phá những kiến thức thú vị về chăm sóc thú cưng</p>
        </div>

        <div id="blogGrid" class="blog-grid">
            <!-- Blog posts will be loaded here -->
        </div>

        <div id="loading" class="loading" style="display: none;">
            <i class="fas fa-spinner fa-spin"></i> Đang tải bài viết...
        </div>

        <div id="error" class="error-message" style="display: none;">
            <i class="fas fa-exclamation-circle"></i>
            <p></p>
        </div>

        <div id="pagination" class="pagination" style="display: none;">
            <button id="prevPage" class="pagination-btn" disabled>
                <i class="fas fa-chevron-left"></i> Trang trước
            </button>
            <span id="pageInfo" class="page-info">Trang 1</span>
            <button id="nextPage" class="pagination-btn">
                Trang sau <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <script>
    let currentPage = 1;
    const postsPerPage = 6;
    let totalPosts = 0;

    function truncateWords(text, maxWords) {
        const words = text.split(' ');
        if (words.length <= maxWords) return text;
        return words.slice(0, maxWords).join(' ');
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadBlogPosts();
        
        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                loadBlogPosts();
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            if (currentPage * postsPerPage < totalPosts) {
                currentPage++;
                loadBlogPosts();
            }
        });
    });

    function loadBlogPosts() {
        const blogGrid = document.getElementById('blogGrid');
        const loading = document.getElementById('loading');
        const error = document.getElementById('error');
        const errorMessage = error.querySelector('p');
        const pagination = document.getElementById('pagination');
        const prevPageBtn = document.getElementById('prevPage');
        const nextPageBtn = document.getElementById('nextPage');
        const pageInfo = document.getElementById('pageInfo');

        loading.style.display = 'block';
        error.style.display = 'none';
        blogGrid.innerHTML = '';
        pagination.style.display = 'none';

        fetch('http://localhost:3000/blog-service/posts')
            .then(response => response.json())
            .then(posts => {
                loading.style.display = 'none';
                totalPosts = posts.length;
                
                if (posts.length === 0) {
                    errorMessage.textContent = 'Chưa có bài viết nào.';
                    error.style.display = 'block';
                    return;
                }

                // Debug log
                console.log('All posts:', posts);

                // Tính toán số trang
                const totalPages = Math.ceil(posts.length / postsPerPage);
                const startIndex = (currentPage - 1) * postsPerPage;
                const endIndex = startIndex + postsPerPage;
                const currentPosts = posts.slice(startIndex, endIndex);

                // Hiển thị phân trang
                pagination.style.display = 'flex';
                prevPageBtn.disabled = currentPage === 1;
                nextPageBtn.disabled = currentPage === totalPages;
                pageInfo.textContent = `Trang ${currentPage} / ${totalPages}`;

                currentPosts.forEach(post => {
                    // Debug log
                    console.log('Processing post:', post);
                    
                    const date = new Date(post.created_at).toLocaleDateString('vi-VN', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    
                    const excerpt = truncateWords(post.content, 10);
                    const postId = post.post_id || '';

                    // Debug log
                    console.log('Post ID:', postId);

                    const postHtml = `
                        <div class="blog-card">
                            <div class="blog-image-container">
                                <img src="${post.image || 'images/default-blog.jpg'}" 
                                     alt="${post.title}" 
                                     class="blog-image">
                            </div>
                            <div class="blog-content">
                                <h2 class="blog-title">${post.title}</h2>
                                <p class="blog-excerpt">${excerpt}</p>
                                <div class="blog-meta">
                                    <span class="blog-date">
                                        <i class="far fa-calendar-alt"></i>
                                        ${date}
                                    </span>
                                    <a href="blog-detail.php?id=${postId}" class="read-more">
                                        Đọc thêm
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;

                    blogGrid.innerHTML += postHtml;
                });
            })
            .catch(err => {
                loading.style.display = 'none';
                errorMessage.textContent = 'Có lỗi xảy ra khi tải bài viết. Vui lòng thử lại sau.';
                error.style.display = 'block';
                console.error('Error loading blog posts:', err);
            });
    }
    </script>
</body>
</html>
