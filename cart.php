<?php
session_start();
include 'admin/controller/database/db.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['ID'];

// Fetch cart items for the logged-in user
$sql = "SELECT * FROM cart_items WHERE user_id = '$user_id'";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Cart</title>
    <style>
    /* Glassmorphism Style */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 20px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        width: 80%;
        margin: 20px auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: rgba(0, 0, 0, 0.1);
        color: #333;
    }

    tr:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    h2 {
        text-align: center;
        color: #333;
    }
    </style>
    <?php include 'css.php'; ?>
</head>

<body>
    <?php include 'menu2.php'; ?>
    <div class="row  d-flex  justify-content-center  mt-3 mb-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">


                    <div class="card-header text text-dark text-center">
                        <h3>Your Cart</h3>
                    </div>

                    <div class="card-body text text-dark">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            echo '<tr>';
            echo '<td>' . $row['product_name'] . '</td>';
            echo '<td>$' . $row['product_price'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>$' . $row['total_price'] . '</td>';
            echo '<td>
                <!-- Buy Form -->
                <form method="post" action="buy.php">
                    <input type="hidden" name="item_id" value="' . $row['product_id'] . '">
                    <button type="submit" class="btn">Buy</button>
                </form>

                <!-- Delete Form -->
                <form method="post" action="">
                    <input type="hidden" name="item_id" value="' . $row['product_id'] . '">
                    <button type="submit" class="btn" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</button>
                </form>
            </td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">Your cart is empty.</td></tr>';
    }
    ?>
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>

</html>