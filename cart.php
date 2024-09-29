<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "Agro";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// mysqli_close($conn);

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <?php include 'css.php'; ?>
</head>
<style>
    .tbl {
        background: rgba(255, 255, 255, 0.4);
        border-radius: 16px;
        border: 1px solid rgba(7, 6, 6, 0.4);
    }
</style>

<body>
    <?php
    // Check the user's role and include the appropriate menu
    if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == 2) {
        include 'menu2.php';
    } else {
        include 'menu.php';
    }
    ?>
    <div class="container">
        <div class="card mt-3 p-2 mb-3 text text-center">
            <div class="card-header text text-dark text-center mb-3">
                <h3>Shopping Cart</h3>
            </div>
            <table class="tbl table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price(₹)</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0; // Initialize $total_price

                    if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                        foreach ($_SESSION["cart"] as $product_id => $item) {
                            $total_item_price = $item["price"] * $item["quantity"];
                            $total_price += $total_item_price;
                            echo "<tr>
                                <td>" . htmlspecialchars($item["name"]) . "</td>
                                <td>$" . htmlspecialchars($item["price"]) . "</td>
                                <td>" . htmlspecialchars($item["quantity"]) . "</td>
                                <td>$" . htmlspecialchars($total_item_price) . "</td>
                                <td>
                                    <form method='POST' action='cash.php'>
                                        <input type='hidden' name='product_id' value='" . htmlspecialchars($product_id) . "'>
                                        
                                        <button type='submit' name='deletefromcart' class='btn btn-danger'>Delete</button>
                                  
                                        <input type='hidden' name='product_id' value='" . htmlspecialchars($product_id) . "'>
                                        
                                        <button type='submit' name='buy' class='btn btn-danger'>buy</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Cart is empty</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <h3>Total price: ₹<?php echo $total_price; ?></h3>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>

</html>
