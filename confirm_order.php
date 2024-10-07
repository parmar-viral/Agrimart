<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Confirmation</title>
    <style>
        .confirmation-message {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <?php include 'menu2.php'; ?>
    
    <div class="confirmation-message">
        <h2>Thank you for your order!</h2>
        <p>Your order has been successfully placed and is currently being processed.</p>
        <p><a href="orders.php">View My Orders</a></p>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>
</html>
