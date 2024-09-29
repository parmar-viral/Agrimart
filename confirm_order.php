<?php
session_start();

// Handle order confirmation logic here
// Clear the cart after order confirmation
if (isset($_SESSION["cart"])) {
    unset($_SESSION["cart"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <?php include 'css.php'; ?>
</head>
<body>
    <?php
    if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == 2) {
        include 'menu2.php';
    } else {
        include 'menu.php';
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card glass-card">
                    <div class="card-body text-center">
                        <h3>Order Confirmed</h3>
                        <p>Thank you for your order! Your Cash on Delivery order has been placed successfully.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>
</html>
