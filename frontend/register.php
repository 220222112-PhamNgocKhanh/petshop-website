<!DOCTYPE html>
<html>
<head>
    <title>Pet Shop | Register</title>
    <meta charset="iso-8859-1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/header.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link href="css/register.css" rel="stylesheet" type="text/css"> <!-- Liên kết file register.css -->
</head>
<body>
<?php include 'header.php'; ?>
    <div id="body">
        <div id="content">
            <div class="content">
                <h2>Register</h2>
                <div>
                    <p>Create a new account to join the Pet Shop community!</p>
                </div>
                <form id="register-form" class="register-form">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                    
                    <button type="submit">Register</button>
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>
            <div id="sidebar">
                <div class="connect">
                    <h2>Follow Us</h2>
                    <ul>
                        <li><a class="facebook" href="#">Facebook</a></li>
                        <li><a class="subscribe" href="#">Subscribe</a></li>
                        <li><a class="twitter" href="#">Twitter</a></li>
                        <li><a class="flicker" href="#">Flicker</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="featured">
            <ul>
                <li><a href="#"><img src="images/organic-and-chemical-free.jpg" width="300" height="90" alt=""></a></li>
                <li><a href="#"><img src="images/good-food.jpg" width="300" height="90" alt=""></a></li>
                <li class="last"><a href="#"><img src="images/pet-grooming.jpg" width="300" height="90" alt=""></a></li>
            </ul>
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
            <div class="section">Copyright © 2012 <a href="#">Company Name</a> All rights reserved | Website Template By <a target="_blank" href="http://www.freewebsitetemplates.com/">freewebsitetemplates.com</a></div>
        </div>
    </div>
    <script>
    document.getElementById('register-form').addEventListener('submit', async function (e) {
        e.preventDefault(); // Ngăn form gửi dữ liệu theo cách mặc định

        // Lấy dữ liệu từ form
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // Kiểm tra mật khẩu và xác nhận mật khẩu
        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        try {
            // Gửi dữ liệu đến API backend
            const response = await fetch('http://localhost:4000/user-service/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username, email, password }),
            });

            const result = await response.json();

            if (response.ok) {
                alert('Registration successful!');
                console.log(result); // Xem thông tin trả về từ server
                // Chuyển hướng đến trang đăng nhập
                window.location.href = 'login.php';
            } else {
                alert(result.message || 'Registration failed!');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while registering.');
        }
    });
</script>
</body>
</html>