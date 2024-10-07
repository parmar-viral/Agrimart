<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'admin/controller/database/db.php'; // Database connection

// Check if the database connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['ID'];

// Fetch order history
$sql = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY created_at DESC";
$res = mysqli_query($conn, $sql);

// Check if the SQL query executed successfully
if (!$res) {
    die("Error executing query: " . mysqli_error($conn));
}
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
                    echo '<td>' . $row['user_id'] . '</td>';
                    echo '<td>' . $row['quantity'] . '</td>';
                    echo '<td>$' . $row['total_price'] . '</td>';
                    echo '<td>' . $row['created_at'] . '</td>';
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
