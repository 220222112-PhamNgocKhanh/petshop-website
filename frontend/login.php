<!DOCTYPE html>
<html>
<head>
    <title>Pet Shop | Login</title>
    <meta charset="iso-8859-1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/login.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet" type="text/css"> <!-- Liên kết file custom.css -->
</head>
<body>
    <div id="header"> 
        <a href="#" id="logo"><img src="images/logo.gif" width="310" height="114" alt=""></a>
        <ul class="navigation">
            <li><a href="index.php">Home</a></li>
            <li><a href="petmart.php">PetMart</a></li>
            <li><a href="about.php">About us</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="petguide.php">PetGuide</a></li>
            <li><a href="contact.php">Contact us</a></li>
            <li class="active" ><a href="login.php" ><img src="images/login.png"  height="25" width="25"></a></li>
        </ul>
    </div>
    <div id="body">
        <div id="content">
            <div class="content">
                <div class="login-container">
                    <h2>Login</h2>
                    <div>
                        <p>Please enter your credentials to log in to your Pet Shop account.</p>
                    </div>
                    <form id="login-form" class="login-form">
                    <label for="username"> Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        
                        <button type="submit">Login</button>
                        <p>Not a member? <a href="register.php">Register here</a></p>
                    </form>

                    <!-- Thêm script xử lý AJAX -->
                    <script>
                        document.getElementById('login-form').addEventListener('submit', async function (e) {
                            e.preventDefault(); // Ngăn form gửi dữ liệu theo cách mặc định

                            const username = document.getElementById('username').value;
                            const password = document.getElementById('password').value;

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
                                    alert('Login successful!');
                                    console.log(result); // Xem thông tin trả về từ server

                                } else {
                                    alert(result.message || 'Login failed!');
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                alert('An error occurred while logging in.');
                            }
                        });
                    </script>
                </div>
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
</body>
</html>