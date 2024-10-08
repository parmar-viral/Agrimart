<?php
session_start();
include 'controller/database/db.php'; // Assuming database connection

// Ensure admin login check
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

// Fetch all orders
$sql = "SELECT orders.id, orders.user_id, users.username, orders.product_id, orders.quantity, orders.total_price, orders.order_date 
        FROM orders 
        JOIN users ON orders.user_id = users.id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin - View Orders</title>
    <?php include 'css.php';?>
</head>

<body>
    <div class="page-wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="content">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-12">

                        <!-- Display All orders -->
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">All Orders</h2>
                            <div class="table-responsive glass-table">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="col">Order ID</th>
                                            <th class="col">User</th>
                                            <th class="col">Product ID</th>
                                            <th class="col">Quantity</th>
                                            <th class="col">Total Price</th>
                                            <th class="col">Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td scope='row'>{$row['id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['product_id']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>{$row['total_price']}</td>
                                    <td>{$row['order_date']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No orders found.</td></tr>";
                    }
                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php';?>
</body>

</html>