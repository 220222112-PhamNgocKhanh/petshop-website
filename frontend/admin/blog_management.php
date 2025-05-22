<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .content {
            /* margin-left: 260px; */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .blog-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
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
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }

        .add-blog-btn:hover {
            background: #218838;
        }

        /* .blog-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        

        .blog-table th, .blog-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
            color: #222;
            background: #fff;
        }

        .blog-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #000;
            border-top: 1px solid #e9ecef;
        }

        .blog-table tr:last-child td {
            border-bottom: none;
        } */

        .blog-table tr:hover {
            background-color: #f5f5f5;
        }

        .blog-image {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #e9ecef;
            background: #fafbfc;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            font-size: 14px;
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
            width: 60%;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .close-btn {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #666;
        }

        .close-btn:hover {
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .thumbnail-preview {
            max-width: 150px;
            max-height: 100px;
            margin-top: 10px;
            border-radius: 4px;
            display: none;
            object-fit: cover;
        }

        #modalTitle {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.5em;
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

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 10px;
        }

        .pagination button {
            padding: 8px 15px;
            border: 1px solid #ddd;
            background-color: white;
            color: #333;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .pagination button:hover:not(:disabled) {
            background-color: #f0f0f0;
            border-color: #999;
        }

        .pagination button:disabled {
            background-color: #f5f5f5;
            color: #999;
            cursor: not-allowed;
        }

        .pagination span {
            padding: 8px 15px;
            color: #666;
        }

        .blog-container {
            margin-bottom: 20px;
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
                    <label for="thumbnail">Hình ảnh đại diện</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(this)">
                    <img id="thumbnailPreview" class="thumbnail-preview" src="" alt="Preview">
                </div>
                <button type="submit" class="add-blog-btn">Lưu bài viết</button>
            </form>
        </div>
    </div>

    <script>
        let currentPage = 1;
        const blogsPerPage = 20;
        let allBlogs = [];

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

                allBlogs = await response.json();
                if (Array.isArray(allBlogs)) {
                    displayBlogs(allBlogs);
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

            // Tính toán phân trang
            const startIndex = (currentPage - 1) * blogsPerPage;
            const endIndex = startIndex + blogsPerPage;
            const paginatedBlogs = blogs.slice(startIndex, endIndex);

            // Hiển thị blog cho trang hiện tại
            paginatedBlogs.forEach(blog => {
                const row = document.createElement('tr');
                const createdDate = new Date(blog.created_at).toLocaleDateString('vi-VN', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                row.innerHTML = `
                    <td>
                        <img src="../../blog-service/public${blog.thumbnail}" 
                             alt="${blog.title}" 
                             class="blog-image"
                             onerror="this.src='../images/default-blog.jpg'">
                    </td>
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

            // Tạo phân trang
            createPagination(blogs.length);
        }

        function createPagination(totalBlogs) {
            const totalPages = Math.ceil(totalBlogs / blogsPerPage);
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination';
            paginationContainer.innerHTML = `
                <button onclick="changePage(1)" ${currentPage === 1 ? 'disabled' : ''}>Đầu</button>
                <button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>Trước</button>
                <span>Trang ${currentPage} / ${totalPages}</span>
                <button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>Sau</button>
                <button onclick="changePage(${totalPages})" ${currentPage === totalPages ? 'disabled' : ''}>Cuối</button>
            `;

            // Xóa phân trang cũ nếu có
            const oldPagination = document.querySelector('.pagination');
            if (oldPagination) {
                oldPagination.remove();
            }

            // Thêm phân trang mới
            document.querySelector('.blog-container').appendChild(paginationContainer);
        }

        function changePage(newPage) {
            currentPage = newPage;
            displayBlogs(allBlogs);
        }

        let currentBlogId = null;

        function openModal(blogId = null) {
            currentBlogId = blogId;
            document.getElementById('blogModal').style.display = 'block';
            document.getElementById('modalTitle').textContent = blogId ? 'Sửa bài viết' : 'Thêm bài viết mới';
            document.getElementById('blogForm').reset();
            document.getElementById('thumbnailPreview').style.display = 'none';
            
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
                
                // Hiển thị hình ảnh hiện tại
                const thumbnailPreview = document.getElementById('thumbnailPreview');
                thumbnailPreview.src = `../../blog-service/public${blog.thumbnail}`;
                thumbnailPreview.style.display = 'block';
            } catch (error) {
                console.error('Error:', error);
                showMessage('Lỗi khi tải thông tin bài viết: ' + error.message, true);
            }
        }

        function previewImage(input) {
            const preview = document.getElementById('thumbnailPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
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
            const thumbnailFile = document.getElementById('thumbnail').files[0];

            if (!title || !content) {
                showMessage('Vui lòng điền đầy đủ tiêu đề và nội dung', true);
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('content', content);
            if (thumbnailFile) {
                formData.append('thumbnail', thumbnailFile);
            }

            try {
                const url = currentBlogId ? 
                    `http://localhost:3000/blog-service/posts/${currentBlogId}` :
                    'http://localhost:3000/blog-service/posts';

                const method = currentBlogId ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
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