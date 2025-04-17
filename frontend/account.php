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
          <div class="account-tab" data-tab="addresses">Addresses</div>
          <div class="account-tab" data-tab="security">Security</div>

        </div>
        
        <!-- Profile Tab -->
        <div class="tab-content active" id="profile-tab">
          <div class="profile-header">
            <img src="/api/placeholder/100/100" alt="Profile Picture" class="profile-image">
            <div class="profile-info">
              <h3>John Doe</h3>
            </div>
          </div>
          
          <form id="profile-form">
            
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" class="form-control" value="john.doe@example.com">
            </div>
            
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" class="form-control" value="(123) 456-7890">
            </div>
            
            <div class="form-group">
              <label for="bio">About You</label>
              <textarea id="bio" class="form-control" rows="4">I love pets and have been a pet owner for over 10 years. I have two lovely dogs named Max and Bella, and a cat named Oliver.</textarea>
            </div>
            
            <div class="form-group">
              <label for="profile-pic">Profile Picture</label>
              <input type="file" id="profile-pic" accept="image/*">
            </div>
            
            <button type="submit" class="btn">Save Changes</button>
          </form>
        </div>
        
        <!-- Addresses Tab -->
        <div class="tab-content" id="addresses-tab">
          <h3>Saved Addresses</h3>
          
          <div class="address-card">
            <div class="address-actions">
              <button class="btn btn-outline">Edit</button>
              <button class="btn btn-outline">Delete</button>
            </div>
            <h4>Home <span class="default-badge">Default</span></h4>
            <p>John Doe</p>
            <p>123 Pet Street</p>
            <p>Animalia, CA 90210</p>
            <p>United States</p>
            <p>Phone: (123) 456-7890</p>
          </div>
          
          <div class="address-card">
            <div class="address-actions">
              <button class="btn btn-outline">Edit</button>
              <button class="btn btn-outline">Delete</button>
            </div>
            <h4>Work</h4>
            <p>John Doe</p>
            <p>456 Office Avenue</p>
            <p>Animalia, CA 90211</p>
            <p>United States</p>
            <p>Phone: (123) 456-7890</p>
          </div>
          
          <button class="btn">Add New Address</button>
        </div>
        
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
          <div id="message-box" style="margin-top: 10px;"></div>

          <script>
              document.getElementById('change-password-form').addEventListener('submit', async function (e) {
                  e.preventDefault();

                  const oldPassword = document.getElementById('old-password').value;
                  const newPassword = document.getElementById('new-password').value;
                  const confirmPassword = document.getElementById('confirm-password').value;
                  const messageBox = document.getElementById('message-box');

                  if (newPassword !== confirmPassword) {
                      messageBox.style.color = 'red';
                      messageBox.textContent = 'Mật khẩu mới không trùng khớp';
                      return;
                  }

                  const token = localStorage.getItem('token');
                  if (!token) {
                      messageBox.style.color = 'red';
                      messageBox.textContent = 'Bạn chưa đăng nhập! Vui lòng đăng nhập lại.';
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
                      
                      if (response.status === 401) {
                          messageBox.style.color = 'red';
                          messageBox.textContent = 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.';
                          localStorage.removeItem('token');
                          setTimeout(() => {
                              window.location.href = 'login.php';
                          }, 2000);
                          return;
                      }

                      messageBox.style.color = response.ok ? 'green' : 'red';
                      messageBox.textContent = result.message;

                      if (response.ok) {
                          document.getElementById('change-password-form').reset();
                      }

                  } catch (error) {
                      console.error('Lỗi:', error);
                      messageBox.style.color = 'red';
                      messageBox.textContent = 'Lỗi kết nối. Vui lòng kiểm tra lại kết nối mạng và thử lại.';
                  }
              });
              </script>

          
          <hr style="margin: 30px 0;">
          
          <h3>Two-Factor Authentication</h3>
          <p>Add an extra layer of security to your account.</p>
          <button class="btn btn-outline">Enable Two-Factor Authentication</button>
          
          <hr style="margin: 30px 0;">
          
          <h3>Login History</h3>
          <p>Review your recent login activity.</p>
          <table style="width:100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
              <tr style="background-color: #f9f9f9;">
                <th style="text-align: left; padding: 10px; border-bottom: 1px solid #ddd;">Date</th>
                <th style="text-align: left; padding: 10px; border-bottom: 1px solid #ddd;">Device</th>
                <th style="text-align: left; padding: 10px; border-bottom: 1px solid #ddd;">Location</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">14 Apr, 2025 - 10:30 AM</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Chrome on Windows</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Los Angeles, CA</td>
              </tr>
              <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">12 Apr, 2025 - 4:15 PM</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Safari on iPhone</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Los Angeles, CA</td>
              </tr>
              <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">10 Apr, 2025 - 9:45 AM</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Chrome on Windows</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Los Angeles, CA</td>
              </tr>
            </tbody>
          </table>
        </div>
      
      </div>
    </div>
    
    <div id="sidebar">
      <div id="section">
        <div>
          <div>
            <h2>Account Options</h2>
            <ul>
              <li><a href="orders.php">My Orders <span></span></a></li>
              <li><a href="wishlist.php">My Wishlist <span></span></a></li>
              <li><a href="reviews.php">My Reviews <span></span></a></li>
              <li><a href="subscriptions.php">Subscriptions <span></span></a></li>
              <li><a href="support.php">Support Tickets <span></span></a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div id="section">
        <div>
          <div>
            <h2>Need Help?</h2>
            <p>Our customer service team is ready to assist you with any questions about your account.</p>
            <a href="contact.php" class="btn" style="display: block; width: auto; text-align: center; margin-top: 15px; text-decoration: none;">Contact Support</a>
          </div>
        </div>
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
      <li> <img src="images/friendly-pets.jpg" width="240" height="186" alt="">
        <h2><a href="#">Friendly Pets</a></h2>
        <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonummy nib. <a class="more" href="#">Read More</a> </p>
      </li>
      <li> <img src="images/pet-lover2.jpg" width="240" height="186" alt="">
        <h2><a href="#">How dangerous are they</a></h2>
        <p> Lorem ipsum dolor sit amet, cons ectetuer adepis cing, sed diam euis. <a class="more" href="#">Read More</a> </p>
      </li>
      <li> <img src="images/healthy-dog.jpg" width="240" height="186" alt="">
        <h2><a href="#">Keep them healthy</a></h2>
        <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diam nonu mmy. <a class="more" href="#">Read More</a> </p>
      </li>
      <li>
        <h2><a href="#">Love...love...love...pets</a></h2>
        <p> Lorem ipsum dolor sit amet, consectetuer adepiscing elit, sed diameusim. <a class="more" href="#">Read More</a> </p>
        <img src="images/pet-lover.jpg" width="240" height="186" alt=""> </li>
    </ul>
  </div>
  <div id="footnote">
    <div class="section">Copyright &copy; 2012 <a href="#">Company Name</a> All rights reserved | Website Template By <a target="_blank" href="http://www.freewebsitetemplates.com/">freewebsitetemplates.com</a></div>
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