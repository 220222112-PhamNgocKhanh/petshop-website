<?php
session_start();

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$page_title = isset($page_title) ? $page_title : 'Admin Dashboard';
$page_description = isset($page_description) ? $page_description : '';
$page_css = isset($page_css) ? $page_css : '';
$content = isset($content) ? $content : 'pages/dashboard.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Pet Shop Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <?php if ($page_css): ?>
    <link rel="stylesheet" href="css/<?php echo $page_css; ?>">
    <?php endif; ?>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="content">
        <?php include $content; ?>
    </div>

    <script src="js/admin.js"></script>
    <?php if (file_exists("js/{$page_css}")): ?>
    <script src="js/<?php echo str_replace('.css', '.js', $page_css); ?>"></script>
    <?php endif; ?>
</body>
</html> 