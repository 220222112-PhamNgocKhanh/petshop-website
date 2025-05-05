<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="sidebar.css">
    <style>
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .blog-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .blog-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-blog-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .add-blog-btn:hover {
            background: #218838;
        }

        .blog-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .blog-table th, .blog-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .blog-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .blog-table tr:hover {
            background-color: #f5f5f5;
        }

        .blog-image {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .edit-btn {
            background: #007bff;
        }

        .edit-btn:hover {
            background: #0056b3;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            background: white;
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group textarea {
            height: 200px;
            resize: vertical;
        }

        #message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            display: none;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="content">
        <div class="blog-container">
            <div class="blog-header">
                <h1>Quản lý Blog</h1>
                <button class="add-blog-btn" onclick="openModal()">
                    <i class="fas fa-plus"></i>
                    Thêm bài viết
                </button>
            </div>

            <div id="message"></div>

            <table class="blog-table">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Ngày đăng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="blogTable">
                    <!-- Dữ liệu blog sẽ được thêm vào đây -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal thêm/sửa blog -->
    <div id="blogModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Thêm bài viết mới</h2>
            <form id="blogForm">
                <div class="form-group">
                    <label for="title">Tiêu đề</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea id="content" name="content" required></textarea>
                </div>
                <button type="submit" class="add-blog-btn">Lưu bài viết</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadBlogs();
        });

        async function loadBlogs() {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    showMessage('Vui lòng đăng nhập lại', true);
                    setTimeout(() => {
                        window.location.href = '../login.php';
                    }, 2000);
                    return;
                }

                const response = await fetch('http://localhost:3000/blog-service/posts', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.status === 403) {
                    showMessage('Bạn không có quyền truy cập trang này', true);
                    setTimeout(() => {
                        window.location.href = '../login.php';
                    }, 2000);
                    return;
                }

                const blogs = await response.json();
                if (Array.isArray(blogs)) {
                    displayBlogs(blogs);
                } else {
                    throw new Error('Dữ liệu không hợp lệ');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tải danh sách blog: ' + error.message, true);
            }
        }

        function displayBlogs(blogs) {
            const tableBody = document.getElementById('blogTable');
            tableBody.innerHTML = '';

            blogs.forEach(blog => {
                const row = document.createElement('tr');
                const createdDate = new Date(blog.created_at).toLocaleDateString('vi-VN', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                row.innerHTML = `
                    <td>${blog.title}</td>
                    <td>${createdDate}</td>
                    <td class="action-buttons">
                        <button class="edit-btn" onclick="editBlog(${blog.post_id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-btn" onclick="deleteBlog(${blog.post_id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        let currentBlogId = null;

        function openModal(blogId = null) {
            currentBlogId = blogId;
            document.getElementById('blogModal').style.display = 'block';
            document.getElementById('modalTitle').textContent = blogId ? 'Sửa bài viết' : 'Thêm bài viết mới';
            document.getElementById('blogForm').reset();
            
            if (blogId) {
                loadBlogData(blogId);
            }
        }

        async function loadBlogData(blogId) {
            try {
                const token = localStorage.getItem('token');
                const response = await fetch(`http://localhost:3000/blog-service/posts/${blogId}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Không thể tải thông tin bài viết');
                }

                const blog = await response.json();
                document.getElementById('title').value = blog.title || '';
                document.getElementById('content').value = blog.content || '';
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tải thông tin bài viết: ' + error.message, true);
            }
        }

        function closeModal() {
            document.getElementById('blogModal').style.display = 'none';
            currentBlogId = null;
        }

        async function saveBlog(event) {
            event.preventDefault();
            const token = localStorage.getItem('token');
            if (!token) {
                showMessage('Vui lòng đăng nhập lại', true);
                return;
            }

            const title = document.getElementById('title').value.trim();
            const content = document.getElementById('content').value.trim();

            if (!title || !content) {
                showMessage('Vui lòng điền đầy đủ tiêu đề và nội dung', true);
                return;
            }

            const blogData = {
                title: title,
                content: content
            };

            try {
                const url = currentBlogId ? 
                    `http://localhost:3000/blog-service/posts/${currentBlogId}` :
                    'http://localhost:3000/blog-service/posts';

                const method = currentBlogId ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify(blogData)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Lỗi khi lưu bài viết');
                }

                showMessage(currentBlogId ? 'Cập nhật bài viết thành công' : 'Thêm bài viết thành công');
                closeModal();
                loadBlogs();
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi lưu bài viết: ' + error.message, true);
            }
        }

        async function editBlog(blogId) {
            openModal(blogId);
        }

        async function deleteBlog(blogId) {
            if (!confirm('Bạn có chắc muốn xóa bài viết này?')) {
                return;
            }

            try {
                const token = localStorage.getItem('token');
                const response = await fetch(`http://localhost:3000/blog-service/posts/${blogId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Không thể xóa bài viết');
                }

                showMessage('Xóa bài viết thành công');
                loadBlogs();
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi xóa bài viết: ' + error.message, true);
            }
        }

        function showMessage(message, isError = false) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = message;
            messageDiv.className = isError ? 'error' : 'success';
            messageDiv.style.display = 'block';
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 3000);
        }

        // Event listeners
        document.getElementById('blogForm').addEventListener('submit', saveBlog);

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('blogModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>