<?php
session_start();
include 'admin/controller/database/db.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['ID'];
$item_id = $_POST['item_id'];

// Fetch the cart item details from the database
$sql = "SELECT * FROM cart_items WHERE user_id = '$user_id' AND product_id = '$item_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $cart_item = mysqli_fetch_assoc($result);

    // Calculate the total price (assuming 'total_price' already contains the correct value)
    $total_price = $cart_item['total_price'];

    // Insert the order into the `orders` table
    $insert_order_sql = "INSERT INTO orders (user_id, total_price, payment_status, order_status) 
                         VALUES ('$user_id', '$total_price', 'Pending', 'Processing')";

    if (mysqli_query($conn, $insert_order_sql)) {
        // Optionally, you can clear the cart after successful order
        $delete_cart_sql = "DELETE FROM cart_items WHERE user_id = '$user_id' AND product_id = '$item_id'";
        mysqli_query($conn, $delete_cart_sql);

        // Redirect to an order confirmation page
        header('Location: confirm_order.php');
        exit();
    } else {
        echo "Error placing order: " . mysqli_error($conn);
    }
} else {
    echo "No item found in your cart.";
}

mysqli_close($conn);
?>
