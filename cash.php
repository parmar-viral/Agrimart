<?php
session_start();

// Simulate retrieving order details based on the session cart
if (isset($_SESSION["cart"])) {
    $cart_items = $_SESSION["cart"];
} else {
    $cart_items = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash on Delivery</title>
    <?php include 'css.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
        }

        /* Styling for the disabled button */
        .btn-disabled {
            background-color: grey;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <?php
    // Check the user's role and include the appropriate menu
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
                    <div class="card-header text-center">
                        <h3>Cash on Delivery</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-center">Thank you for your purchase!</p>
                        <p>Your order details are below:</p>
                        <ul class="list-group">
                            <?php
                            $total_price = 0;
                            foreach ($cart_items as $item) {
                                $item_total = $item['price'] * $item['quantity'];
                                $total_price += $item_total;
                                echo "<li class='list-group-item'>
                                        <strong>" . htmlspecialchars($item['name']) . "</strong> - 
                                        ₹" . htmlspecialchars($item['price']) . " x " . htmlspecialchars($item['quantity']) . 
                                        " = ₹" . htmlspecialchars($item_total) . "
                                      </li>";
                            }
                            ?>
                        </ul>
                        <h4 class="mt-3">Total Price: ₹<?php echo $total_price; ?></h4>
                        
                        <!-- Payment Option: Only Cash on Delivery -->
                        <div class="payment-options mt-4">
                            <h5>Select Payment Method:</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="online" value="online" disabled>
                                <label class="form-check-label" for="online">
                                    Online Payment (Unavailable)
                                </label>
                            </div>
                        </div>

                        <form method="POST" action="confirm_order.php">
                            <button type="submit" class="btn btn-primary btn-block mt-3">Confirm Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>
</html>
