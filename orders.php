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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('path-to-your-background-image.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }

        .glass-table-container {
            background: rgba(255, 255, 255, 0.1); /* Light background with transparency */
            backdrop-filter: blur(10px); /* Frosted glass effect */
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 800px; /* Limit the width for larger screens */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: #fff; /* Text color */
            border-radius: 10px; /* Rounded corners for table */
            overflow: hidden; /* Ensure border radius works */
        }

        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        th {
            background-color: rgba(255, 255, 255, 0.2); /* Header background */
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.3); /* Row hover effect */
        }

        .no-orders {
            color: #f00; /* Color for no orders found */
        }
    </style>
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
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center no-orders'>No orders found.</td></tr>";
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
