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
</head>
<body>
    <h2>Thank you for your purchase!</h2>
    <p>Your order has been placed successfully.</p>
    <a href="orders.php">View Your Orders</a>
</body>
</html>
