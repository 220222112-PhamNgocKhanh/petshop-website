<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Pet Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/login.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/header.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="login-container">
            <div class="login-header">
                <h2>Đăng nhập</h2>
                <p>Vui lòng đăng nhập để tiếp tục</p>
            </div>

            <form id="login-form" class="login-form">
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Nhập tên đăng nhập của bạn"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Nhập mật khẩu của bạn"
                            required>
                    </div>
                </div>

                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>

                <div id="error-message" class="error-message"></div>

                <div class="login-links">
                    <p>
                        Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
                    </p>
                    <p>
                        <a href="forgotPassword.php">Quên mật khẩu?</a>
                    </p>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');

            try {
                const response = await fetch('http://localhost:3000/user-service/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username,
                        password
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    // Lưu token vào localStorage
                    localStorage.setItem('token', data.token);

                    // Giải mã token để lấy role
                    const payload = JSON.parse(atob(data.token.split('.')[1]));
                    const role = payload.role;

                    // Kiểm tra role và chuyển hướng
                    if (role === 'admin') {
                        window.location.href = 'admin/admin.php';
                    } else {
                        window.location.href = 'index.php';
                    }
                } else {
                    errorMessage.textContent = data.message || 'Đăng nhập thất bại';
                    errorMessage.style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = 'Có lỗi xảy ra, vui lòng thử lại';
                errorMessage.style.display = 'block';
            }
        });
    </script>
</body>

</html>