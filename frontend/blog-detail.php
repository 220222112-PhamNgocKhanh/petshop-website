<!DOCTYPE html>
<html>
<head>
    <title>Pet Shop | Blog Detail</title>
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

    <div class="blog-detail-container">
        <div id="blogDetail" class="blog-detail">
            <!-- Blog content will be loaded here -->
        </div>

        <div id="loading" class="loading" style="display: none;">
            <i class="fas fa-spinner fa-spin"></i> Đang tải bài viết...
        </div>

        <div id="error" class="error-message" style="display: none;">
            <i class="fas fa-exclamation-circle"></i>
            <p></p>
        </div>

        <div class="blog-navigation">
            <a href="blog.php" class="back-to-blog">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách bài viết
            </a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const postId = urlParams.get('id');

        if (!postId) {
            showError('Không tìm thấy ID bài viết');
            return;
        }

        loadBlogPost(postId);
    });

    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function showError(message) {
        const error = document.getElementById('error');
        const errorMessage = error.querySelector('p');
        errorMessage.textContent = message;
        error.style.display = 'block';
    }

    function showLoading(show) {
        document.getElementById('loading').style.display = show ? 'block' : 'none';
    }

    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    async function loadBlogPost(postId) {
        const blogDetail = document.getElementById('blogDetail');
        showLoading(true);
        document.getElementById('error').style.display = 'none';
        blogDetail.innerHTML = '';

        try {
            const response = await fetch(`http://localhost:3000/blog-service/posts/${postId}`);
            if (!response.ok) {
                const data = await response.json();
                throw new Error(data.message || 'Không tìm thấy bài viết');
            }

            const post = await response.json();
            showLoading(false);
            
            if (!post) {
                throw new Error('Không tìm thấy bài viết');
            }

            const date = formatDate(post.created_at);
            const thumbnailUrl = post.thumbnail ? `../blog-service/public${post.thumbnail}` : 'images/default-blog.jpg';

            const postHtml = `
                <article class="blog-article">
                    <div class="blog-header">
                        <h1 class="blog-title">${escapeHtml(post.title)}</h1>
                        <div class="blog-meta">
                            <span class="blog-date">
                                <i class="far fa-calendar-alt"></i>
                                ${date}
                            </span>
                        </div>
                    </div>
                    
                    <div class="blog-image-container">
                        <img src="${thumbnailUrl}" 
                             alt="${escapeHtml(post.title)}" 
                             class="blog-image"
                             onerror="this.src='images/default-blog.jpg'">
                    </div>

                    <div class="blog-content">
                        ${post.content || ''}
                    </div>
                </article>
            `;

            blogDetail.innerHTML = postHtml;
        } catch (error) {
            showLoading(false);
            showError(error.message || 'Có lỗi xảy ra khi tải bài viết. Vui lòng thử lại sau.');
            console.error('Error loading blog post:', error);
        }
    }
    </script>
</body>
</html> 