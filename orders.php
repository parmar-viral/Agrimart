<?php
session_start();
include 'admin/controller/database/db.php'; // Assuming database connection

if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['ID']; // Retrieve the user ID from session

// Fetch user orders
$sql = "SELECT * FROM orders WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

// Check if delete order request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $order_id = $_POST['order_id'];
    
    // Prepare the delete query
    $delete_sql = "DELETE FROM orders WHERE id = '$order_id' AND user_id = '$user_id'";
    mysqli_query($conn, $delete_sql);
    
    // Optionally, you can redirect to the same page to refresh the orders list
    header('Location: orders.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Orders</title>
    <?php include 'css.php';?>
</head>

<body>
    <?php include 'menu2.php';?>

    <div class="container">
        <div class="glass-table-container"> <!-- This container wraps the table for glass effect -->
            <h3 class="text-center">My Orders</h3>

            <table class="table"> <!-- Removed table-bordered class for styling -->
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Order Date</th>
                        <th>Actions</th> <!-- Added actions column -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['product_id']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>{$row['total_price']}</td>
                                    <td>{$row['order_date']}</td>
                                    <td>
                                        <form method='POST' action='' style='display:inline;'>
                                            <input type='hidden' name='order_id' value='{$row['id']}'>
                                            <button type='submit' name='delete' class='btn'>Delete</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center no-orders'>No orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'footer.php';?>
    <?php include 'js.php';?>
</body>

</html>
