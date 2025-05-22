<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký | Pet Shop</title>
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
                <h2>Đăng ký</h2>
                <p>Tạo tài khoản mới để tham gia cộng đồng Pet Shop!</p>
            </div>

            <form id="register-form" class="login-form">
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
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Nhập email của bạn"
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

                <div class="form-group">
                    <label for="confirm-password">Xác nhận mật khẩu</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input
                            type="password"
                            id="confirm-password"
                            name="confirm-password"
                            placeholder="Nhập lại mật khẩu của bạn"
                            required>
                    </div>
                </div>

                <button type="submit" class="login-button">
                    <i class="fas fa-user-plus"></i> Đăng ký
                </button>

                <div id="error-message" class="error-message"></div>

                <div class="login-links">
                    <p>
                        Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
                    </p>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.getElementById('register-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const errorMessage = document.getElementById('error-message');

            // Kiểm tra mật khẩu trùng khớp
            if (password !== confirmPassword) {
                errorMessage.textContent = 'Mật khẩu không khớp!';
                errorMessage.style.display = 'block';
                return;
            }

            try {
                const response = await fetch('http://localhost:3000/user-service/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username,
                        email,
                        password
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    alert('Đăng ký thành công!');
                    window.location.href = 'login.php';
                } else {
                    errorMessage.textContent = data.message || 'Đăng ký thất bại';
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