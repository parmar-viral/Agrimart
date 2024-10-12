<?php
session_start();
include 'admin/controller/database/db.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['ID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['item_id'];

    // Fetch product details from cart
    $sql = "SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();

        // Insert into orders table
        $sql = "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $user_id, $product_id, $item['quantity'], $item['total_price']);
        $stmt->execute();

        // Delete from cart after purchase
        $sql = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();

        // Redirect to order success page
        header('Location: confirm_order.php');
        exit();
    } else {
        echo "Product not found in your cart.";
    }
}
?>
