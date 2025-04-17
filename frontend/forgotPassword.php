<!DOCTYPE html>
<html>
<head>
    <title>Pet Shop | Forgot Password</title>
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
                    <h2>Forgot Password</h2>
                    <div>
                        <p>Please enter your email address to reset your password.</p>
                    </div>
                    <form id="forgot-password-form" class="login-form">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        
                        <button type="submit">Send</button>
                        <p id="success-message" style="color: green; font-size: 12px; display: none;">Password reset instructions have been sent to your email.</p>
                        <p id="error-message" style="color: red; font-size: 12px; display: none;">Error: Unable to reset password.</p>
                    </form>

                    <!-- Script xử lý AJAX -->
                    <script>
                        document.getElementById('forgot-password-form').addEventListener('submit', async function (e) {
                            e.preventDefault(); // Ngăn form gửi dữ liệu theo cách mặc định

                            const email = document.getElementById('email').value;
                            const successMessage = document.getElementById('success-message');
                            const errorMessage = document.getElementById('error-message');

                            try {
                                const response = await fetch('http://localhost:3000/user-service/forgot-password', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({ email }),
                                });

                                const result = await response.json();

                                if (response.ok) {
                                    // Thành công
                                    successMessage.style.display = 'block';
                                    successMessage.textContent = 'Password reset instructions have been sent to your email.';
                                    errorMessage.style.display = 'none';
                                } else {
                                    // Thất bại
                                    errorMessage.style.display = 'block';
                                    errorMessage.textContent = result.message || 'Error: Unable to reset password.';
                                    successMessage.style.display = 'none';
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                errorMessage.style.display = 'block';
                                errorMessage.textContent = 'An error occurred while resetting the password.';
                                successMessage.style.display = 'none';
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