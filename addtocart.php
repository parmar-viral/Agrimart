<?php
session_start();
include 'admin/controller/database/db.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['ID']; // Assuming user ID is stored in the session
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = 1; // Default quantity for now

    // Check if the product is already in the cart
    $check_sql = "SELECT * FROM cart_items WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // If product already exists in the cart, update quantity and total price
        $update_sql = "UPDATE cart_items 
                       SET quantity = quantity + 1, 
                           total_price = total_price + $product_price 
                       WHERE user_id = '$user_id' AND product_id = '$product_id'";
        mysqli_query($conn, $update_sql);
    } else {
        // Insert new product into the cart
        $total_price = $product_price * $quantity;
        $insert_sql = "INSERT INTO cart_items (user_id, product_id, product_name, product_price, quantity, total_price)
                       VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$quantity', '$total_price')";
        mysqli_query($conn, $insert_sql);
    }

    $_SESSION['msg'] = "Product added to cart successfully!"; // Success message
    header('Location: cart.php'); // Redirect to the cart page
    exit();
}
