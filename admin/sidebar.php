<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <?php include 'css.php';?>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index.php"><i class="bi bi-house"></i> Dashboard</a>
        <a href="users.php"><i class="bi bi-people"></i> Users</a>
        <a href="category.php"><i class="bi bi-list"></i> Categories</a>
        <a href="products.php"><i class="bi bi-box"></i> Products</a>
        <a href="orders.php"><i class="bi bi-cart"></i> Orders</a>
        <a href="feedback.php"><i class="bi bi-chat-dots"></i> Feedback</a>  
        <a href="analytics.php"><i class="bi bi-bar-chart"></i> Analytics</a>  
        <a href="settings.php"><i class="bi bi-gear"></i> Settings</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
    <?php include 'js.php'; ?>
</body>
</html>