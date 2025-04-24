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
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Ngày đăng</th>
                        <th>Trạng thái</th>
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
                <div class="form-group">
                    <label for="image">Hình ảnh</label>
                    <input type="file" id="image" name="image" accept="image/*">
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

                const response = await fetch('http://localhost:3000/blog-service/blogs', {
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
                displayBlogs(blogs);
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tải danh sách blog', true);
            }
        }

        function displayBlogs(blogs) {
            const tableBody = document.getElementById('blogTable');
            tableBody.innerHTML = '';

            blogs.forEach(blog => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><img src="${blog.image_url || '../images/default-blog.jpg'}" alt="${blog.title}" class="blog-image"></td>
                    <td>${blog.title}</td>
                    <td>${new Date(blog.created_at).toLocaleDateString('vi-VN')}</td>
                    <td>${blog.status ? 'Đã đăng' : 'Nháp'}</td>
                    <td class="action-buttons">
                        <button class="edit-btn" onclick="editBlog(${blog.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-btn" onclick="deleteBlog(${blog.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function openModal(blogId = null) {
            document.getElementById('blogModal').style.display = 'block';
            document.getElementById('modalTitle').textContent = blogId ? 'Sửa bài viết' : 'Thêm bài viết mới';
            // Reset form
            document.getElementById('blogForm').reset();
        }

        function closeModal() {
            document.getElementById('blogModal').style.display = 'none';
        }

        async function saveBlog(event) {
            event.preventDefault();
            // Thêm code xử lý lưu blog
        }

        async function editBlog(blogId) {
            // Thêm code xử lý sửa blog
        }

        async function deleteBlog(blogId) {
            // Thêm code xử lý xóa blog
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