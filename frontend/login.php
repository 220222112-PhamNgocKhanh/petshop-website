<!DOCTYPE html>
<html>
<head>
    <title>Pet Shop | Login</title>
    <meta charset="iso-8859-1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/header.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link href="css/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include 'header.php'; ?>
    <div id="body">
        <div id="content">
            <div class="content">
                <div class="login-container">
                    <h2>Login</h2>
                    <div>
                        <p>Please enter your credentials to log in to your Pet Shop account.</p>
                    </div>
                    <form id="login-form" class="login-form">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        
                        <button type="submit">Login</button>
                        <p id="error-message" style="color: red; font-size: 12px; display: none;">Invalid username or password</p>
                        <p>
                            Not a member? <a href="register.php" style="color: orange;">Register here</a> | 
                            <a href="forgotPassword.php" style="color: blue;">Forgot password?</a>
                        </p>
                    </form>

                    <!-- Script xử lý AJAX -->
                    <!-- Script xử lý AJAX -->
                    <script>
                    document.getElementById('login-form').addEventListener('submit', async function (e) {
                        e.preventDefault(); // Ngăn form gửi dữ liệu theo cách mặc định

                        const username = document.getElementById('username').value;
                        const password = document.getElementById('password').value;
                        const errorMessage = document.getElementById('error-message');

                        try {
                            const response = await fetch('http://localhost:3000/user-service/login', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ username, password }),
                            });

                            const result = await response.json();

                            if (response.ok) {
                                // Sau khi nhận token:
                                const token = result.token;
                                const payload = JSON.parse(atob(token.split('.')[1]));

                                console.log("Role từ token:", payload.role);
                                console.log("Username từ token:", payload.username);

                                // Lưu vào localStorage nếu cần
                                localStorage.setItem('token', token);
                                localStorage.setItem('user', JSON.stringify(payload));

                                // Redirect
                                if (payload.role === 'admin') {
                                    window.location.href = 'admin/admin.php';
                                } else {
                                    window.location.href = 'index.php';
                                }

                            } else {
                                // Đăng nhập thất bại
                                errorMessage.style.display = 'block';
                                errorMessage.textContent = result.message || 'Invalid username or password';
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            errorMessage.style.display = 'block';
                            errorMessage.textContent = 'An error occurred while logging in.';
                        }
                    });
                </script>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="section">
            <ul>
                <li> 
                    <img src="images/friendly-pets.jpg" width="240" height="186" alt="">
                    <h2><a href="#">Friendly Pets</a></h2>
                    <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonummy nib. <a class="more" href="#">Read More</a> </p>
                </li>
                <li> 
                    <img src="images/pet-lover2.jpg" width="240" height="186" alt="">
                    <h2><a href="#">How dangerous are they</a></h2>
                    <p> Lorem ipsum dolor sit amet, cons ectetuer adepis cing, sed diam euis. <a class="more" href="#">Read More</a> </p>
                </li>
                <li> 
                    <img src="images/healthy-dog.jpg" width="240" height="186" alt="">
                    <h2><a href="#">Keep them healthy</a></h2>
                    <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonu mmy. <a class="more" href="#">Read More</a> </p>
                </li>
                <li>
                    <h2><a href="#">Love...love...love...pets</a></h2>
                    <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diameusim. <a class="more" href="#">Read More</a> </p>
                    <img src="images/pet-lover.jpg" width="240" height="186" alt=""> 
                </li>
            </ul>
        </div>
        <div id="footnote">
            <div class="section">Copyright © 2025 <a href="#">Pet Shop</a> All rights reserved.</div>
        </div>
    </div>
</body>
</html>