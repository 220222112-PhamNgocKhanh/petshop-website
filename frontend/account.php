<!DOCTYPE html>
<html>

<head>
  <title>My Account | PetGuide</title>
  <meta charset="iso-8859-1">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/header.css" rel="stylesheet" type="text/css">
  <!--[if IE 6]><link href="css/ie6.css" rel="stylesheet" type="text/css"><![endif]-->
  <!--[if IE 7]><link href="css/ie7.css" rel="stylesheet" type="text/css"><![endif]-->
  <style>
    .account-container {
      padding: 20px;
      background: #fff;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .account-tabs {
      display: flex;
      border-bottom: 1px solid #ddd;
      margin-bottom: 20px;
    }

    .account-tab {
      padding: 10px 20px;
      cursor: pointer;
      border: 1px solid transparent;
      border-bottom: none;
      margin-right: 5px;
      border-radius: 5px 5px 0 0;
    }

    .account-tab.active {
      background: #5c9d7e;
      color: white;
      border-color: #5c9d7e;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    .profile-header {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
    }

    .profile-image {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 20px;
      border: 3px solid #5c9d7e;
    }

    .profile-info h3 {
      margin: 0 0 5px 0;
      font-size: 24px;
    }

    .profile-info p {
      color: #777;
      margin: 0;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
    }

    .form-row {
      display: flex;
      gap: 20px;
    }

    .form-row .form-group {
      flex: 1;
    }

    .btn {
      background: #5c9d7e;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #4a7d62;
    }

    .btn-outline {
      background: transparent;
      border: 1px solid #5c9d7e;
      color: #5c9d7e;
    }

    .btn-outline:hover {
      background: #5c9d7e;
      color: white;
    }

    .address-card {
      border: 1px solid #eee;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      position: relative;
    }

    .address-card h4 {
      margin-top: 0;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }

    .default-badge {
      background: #5c9d7e;
      color: white;
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 12px;
      margin-left: 10px;
    }

    .address-actions {
      position: absolute;
      top: 15px;
      right: 15px;
    }

    .password-requirements {
      font-size: 14px;
      color: #777;
      margin-top: 10px;
    }

    .password-requirements ul {
      padding-left: 20px;
      margin: 5px 0;
    }

    .notification-item {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }

    .notification-checkbox {
      margin-right: 15px;
    }

    .notification-label {
      flex: 1;
    }

    .notification-label p {
      color: #777;
      font-size: 14px;
      margin: 5px 0 0 0;
    }

    .pet-profile {
      border: 1px solid #eee;
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 20px;
      display: flex;
    }

    .pet-image {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 20px;
    }

    .pet-info {
      flex: 1;
    }

    .pet-actions {
      align-self: flex-start;
    }

    .add-pet-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      padding: 15px;
      background: #f9f9f9;
      border: 2px dashed #ddd;
      border-radius: 5px;
      color: #777;
      cursor: pointer;
      transition: all 0.3s;
    }

    .add-pet-btn:hover {
      background: #f0f0f0;
      border-color: #5c9d7e;
      color: #5c9d7e;
    }

    .btn-small {
      padding: 5px 10px !important;
      /* !important để ghi đè style của btn nếu cần */
      font-size: 14px !important;
      min-width: 60px;
    }

    .btn-cancel {
      background-color: #dc3545 !important;
      /* Màu đỏ cho nút cancel */
      color: white !important;
      border: none !important;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>

  <div id="body">
    <div id="content">
      <div class="content">
        <h2>My Account</h2>

        <div class="account-container">
          <!-- Tab Menu -->
          <div class="account-tabs">
            <div class="account-tab active" data-tab="profile">Profile</div>
            <div class="account-tab" data-tab="security">Security</div>

          </div>

          <!-- Profile Tab -->
          <div class="tab-content active" id="profile-tab">
            <div class="profile-header">
              <img id="profile-image" class="profile-image" src="images/default_user.jpg" alt="Profile Picture">
              <div class="profile-info">
                <h3>Loading...</h3>
              </div>
            </div>

            <div class="address-card">
              <div class="address-actions">
                <button type="button" id="edit-btn" class="btn btn-outline">Edit</button>
              </div>
              <div id="view-mode">
                <h4>Địa chỉ</h4>
                <p id="address-display">Loading address...</p>
              </div>
              <div id="edit-mode" style="display: none;">
                <div class="form-group">
                  <label for="edit-address">Địa chỉ</label>
                  <input type="text" id="edit-address" class="form-control">
                </div>
              </div>
            </div>

            <form id="profile-form">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" value="">
              </div>
              <button type="submit" class="btn">Lưu thay đổi</button>
            </form>
            <div id="message-box" style="margin-top: 10px;"></div>
          </div>

          <script>
            document.addEventListener('DOMContentLoaded', async () => {
              const token = localStorage.getItem('token');
              if (!token) {
                alert('Bạn chưa đăng nhập!');
                window.location.href = 'login.php';
                return;
              }

              const payload = JSON.parse(atob(token.split('.')[1]));
              const userId = payload.user_id;
              let currentUser = null;

              // Lấy các element
              const viewMode = document.getElementById('view-mode');
              const editMode = document.getElementById('edit-mode');
              const editBtn = document.getElementById('edit-btn');
              const editAddress = document.getElementById('edit-address');
              const messageBox = document.getElementById('message-box');

              // Hàm hiển thị thông báo
              const showMessage = (message, isError = false) => {
                messageBox.style.color = isError ? 'red' : 'green';
                messageBox.textContent = message;
              };

              // Hàm tải thông tin người dùng
              async function loadUserInfo() {
                try {
                  const res = await fetch(`http://localhost:3000/user-service/user/${userId}`, {
                    headers: {
                      Authorization: 'Bearer ' + token
                    }
                  });

                  const user = await res.json();
                  if (!res.ok) throw new Error(user.message || 'Không thể lấy thông tin');

                  currentUser = user;

                  // Cập nhật giao diện
                  document.querySelector('.profile-info h3').textContent = user.username;
                  document.getElementById('address-display').textContent = user.address || 'Chưa có địa chỉ';
                  document.getElementById('email').value = user.email || '';
                  editAddress.value = user.address || '';

                } catch (err) {
                  console.error('Lỗi:', err);
                  showMessage('Không thể tải thông tin người dùng', true);
                }
              }
              // Xử lý nút Edit
              editBtn.addEventListener('click', () => {
                if (editBtn.textContent === 'Edit') {
                  viewMode.style.display = 'none';
                  editMode.style.display = 'block';
                  editBtn.textContent = 'Cancel';
                  editBtn.classList.add('btn-small', 'btn-cancel'); // Thêm class mới
                } else {
                  viewMode.style.display = 'block';
                  editMode.style.display = 'none';
                  editBtn.textContent = 'Edit';

                }
              });

              // Xử lý form cập nhật
              document.getElementById('profile-form').addEventListener('submit', async (e) => {
                e.preventDefault();

                const updatedData = {
                  email: document.getElementById('email').value,
                  address: editAddress.value
                };

                try {
                  const updateRes = await fetch('http://localhost:3000/user-service/update', {
                    method: 'PUT',
                    headers: {
                      'Content-Type': 'application/json',
                      Authorization: 'Bearer ' + token
                    },
                    body: JSON.stringify(updatedData)
                  });

                  const result = await updateRes.json();

                  if (updateRes.status === 401) {
                    showMessage('Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại', true);
                    localStorage.removeItem('token');
                    setTimeout(() => {
                      window.location.href = 'login.php';
                    }, 2000);
                    return;
                  }

                  if (updateRes.ok) {
                    showMessage('Cập nhật thông tin thành công');
                    // Chuyển về chế độ xem
                    viewMode.style.display = 'block';
                    editMode.style.display = 'none';
                    editBtn.textContent = 'Edit';
                    editBtn.classList.remove('btn-small', 'btn-cancel');
                    // Tải lại thông tin mới
                    await loadUserInfo();
                  } else {
                    // Xử lý các loại lỗi cụ thể
                    if (result.code === 'ER_DUP_ENTRY') {
                      showMessage('Email này đã được sử dụng bởi tài khoản khác', true);
                    } else {
                      showMessage(result.message || 'Cập nhật thất bại', true);
                    }
                  }
                } catch (err) {
                  console.error('Lỗi:', err);
                  showMessage('Lỗi kết nối, vui lòng thử lại sau', true);
                }
              });

              // Tải thông tin người dùng khi trang được load
              await loadUserInfo();
            });
          </script>

          <!-- Security Tab -->
          <div class="tab-content" id="security-tab">

            <form id="change-password-form">
              <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="old-password" required class="form-control">
              </div>

              <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" required class="form-control">
              </div>

              <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" required class="form-control">
              </div>

              <button type="submit" class="btn">Update Password</button>
            </form>
            <div id="password-message-box" style="margin-top: 10px;"></div>

            <script>
              document.getElementById('change-password-form').addEventListener('submit', async function(e) {
                e.preventDefault();

                const oldPassword = document.getElementById('old-password').value;
                const newPassword = document.getElementById('new-password').value;
                const confirmPassword = document.getElementById('confirm-password').value;
                const messageBox = document.getElementById('password-message-box');

                const showMessage = (message, isError = false) => {
                  messageBox.style.color = isError ? 'red' : 'green';
                  messageBox.textContent = message;
                };

                // Kiểm tra mật khẩu mới
                if (!newPassword) {
                  showMessage('Vui lòng nhập mật khẩu mới', true);
                  return;
                }

                // Kiểm tra xác nhận mật khẩu
                if (newPassword !== confirmPassword) {
                  showMessage('Mật khẩu mới không trùng khớp', true);
                  return;
                }

                const token = localStorage.getItem('token');
                if (!token) {
                  showMessage('Bạn chưa đăng nhập! Vui lòng đăng nhập lại.', true);
                  setTimeout(() => {
                    window.location.href = 'login.php';
                  }, 2000);
                  return;
                }

                try {
                  const response = await fetch('http://localhost:3000/user-service/change-password', {
                    method: 'PUT',
                    headers: {
                      'Content-Type': 'application/json',
                      'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                      old_password: oldPassword,
                      new_password: newPassword
                    })
                  });

                  const result = await response.json();

                  // Kiểm tra message trước
                  if (result.message.includes('Mật khẩu hiện tại không đúng')) {
                    showMessage('Mật khẩu hiện tại không đúng', true);
                    return;
                  }

                  // Sau đó mới kiểm tra status 401 cho các trường hợp khác
                  if (response.status === 401) {
                    showMessage('Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.', true);
                    localStorage.removeItem('token');
                    setTimeout(() => {
                      window.location.href = 'login.php';
                    }, 2000);
                    return;
                  }

                  if (response.ok) {
                    showMessage('Đổi mật khẩu thành công! Vui lòng đăng nhập lại.');
                    document.getElementById('change-password-form').reset();
                    setTimeout(() => {
                      localStorage.removeItem('token');
                      window.location.href = 'login.php';
                    }, 2000);
                  } else {
                    showMessage(result.message || 'Đổi mật khẩu thất bại', true);
                  }

                } catch (error) {
                  console.error('Lỗi:', error);
                  showMessage('Lỗi kết nối. Vui lòng kiểm tra lại kết nối mạng và thử lại.', true);
                }
              });
            </script>

          </div>

        </div>
      </div>

      
    </div>

    

  

  <script>
    // JavaScript để xử lý chức năng tab
    document.addEventListener('DOMContentLoaded', function() {
      const accountTabs = document.querySelectorAll('.account-tab');
      const tabContents = document.querySelectorAll('.tab-content');

      accountTabs.forEach(tab => {
        tab.addEventListener('click', function() {
          // Xóa lớp active từ tất cả các tab
          accountTabs.forEach(t => t.classList.remove('active'));
          tabContents.forEach(c => c.classList.remove('active'));

          // Thêm lớp active vào tab đã click
          this.classList.add('active');

          // Hiển thị nội dung tab tương ứng
          const tabName = this.getAttribute('data-tab');
          document.getElementById(tabName + '-tab').classList.add('active');
        });
      });

    });
  </script>
</body>

</html>