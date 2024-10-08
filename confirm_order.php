<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Success</title>
    <?php include 'css.php';?>
</head>

<body>
    <?php include 'menu2.php';?>

    <div class="row d-flex justify-content-center mt-3 mb-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">
                    <div class="card-header text-dark text-center">
                        <h3>Order Confirm</h3>
                    </div>
                    <div class="card-body text-dark text-center">
                        <h2>Order Placed Successfully!</h2>
                        <p>Thank you for your purchase. Your order has been placed.</p>
                        <a href="cart.php" class="btn mt-2">Back to Cart</a>
                        <a href="index.php" class="btn mt-2">Continue Shopping</a>
                        <a href="orders.php" class="btn mt-2">Check My Orders</a> <!-- New Button -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php';?>
    <?php include 'js.php';?>
</body>

</html>
