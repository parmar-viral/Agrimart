<?php
session_start();
include 'admin/controller/database/db.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['ID'];

// Fetch order history
$sql = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Orders</title>
</head>
<body>
    <h2>Your Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    echo '<tr>';
                    echo '<td>' . $row['product_id'] . '</td>';
                    echo '<td>' . $row['quantity'] . '</td>';
                    echo '<td>$' . $row['total_price'] . '</td>';
                    echo '<td>' . $row['order_date'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">You have no orders.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>
