<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu | Pet Shop</title>
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
                <h2>Quên mật khẩu</h2>
                <p>Vui lòng nhập email của bạn để đặt lại mật khẩu</p>
            </div>

            <form id="forgot-password-form" class="login-form">
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

                <button type="submit" class="login-button">
                    <i class="fas fa-paper-plane"></i> Gửi yêu cầu
                </button>

                <div id="error-message" class="error-message"></div>
                <div id="success-message" class="success-message"></div>

                <div class="login-links">
                    <p>
                        <a href="login.php">Quay lại đăng nhập</a>
                    </p>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.getElementById('forgot-password-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');

            try {
                const response = await fetch('http://localhost:3000/user-service/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();
                if (response.ok) {
                    successMessage.textContent = 'Hướng dẫn đặt lại mật khẩu đã được gửi đến email của bạn.';
                    successMessage.style.display = 'block';
                    errorMessage.style.display = 'none';
                } else {
                    errorMessage.textContent = data.message || 'Không thể gửi yêu cầu đặt lại mật khẩu';
                    errorMessage.style.display = 'block';
                    successMessage.style.display = 'none';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = 'Có lỗi xảy ra, vui lòng thử lại';
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
            }
        });
    </script>
</body>

</html>