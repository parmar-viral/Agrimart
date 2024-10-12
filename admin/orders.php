<?php
include 'error.php';
session_start();
if (!isset($_SESSION['ID'])) {
    header('Location: login.php');
    exit();
}
// Check for a success message in session
$msg = null;
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']); // Clear the message from the session after it's been displayed
    echo $msg;
}
if ($_SESSION['ROLE'] == 0) {
    include_once('controller/order_controller.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin - View Orders</title>
    <?php include 'css.php'; ?>
</head>

<body>
    <div class="page-wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="content">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                    <?php if ($msg) { ?>
                        <div class="alert alert-info text-center">
                            <?php echo $msg; ?>
                        </div>
                        <?php } ?>
                        <!-- Display All orders -->
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">All Orders</h2>
                            <div class="table-responsive glass-table">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="col">Order ID</th>
                                            <th class="col">User</th>
                                            <th class="col">Product Name</th>
                                            <th class="col">Quantity</th>
                                            <th class="col">Total Price</th>
                                            <th class="col">Order Date</th>
                                            <th class="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                          $result = $obj->view();
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>
                                                        <td scope='row'>{$row['id']}</td>
                                                        <td>{$row['username']}</td>
                                                        <td>{$row['product_name']}</td>
                                                        <td>{$row['quantity']}</td>
                                                        <td>{$row['total_price']}</td>
                                                        <td>{$row['order_date']}</td>
                                                        <td>
                                                            <form action='#' method='POST'>
                                                                <input type='hidden' value='{$row['id']}' name='order_id'>
                                                                <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateOrderModal' onclick='editOrder({$row['id']}, {$row['quantity']}, {$row['total_price']}, {$row['product_price']})'><i class='bi bi-pencil-square'></i></button>
                                                                <button class='btn btn-danger btn-sm' type='submit' name='delete' onclick='return confirm(\"Are you sure to delete?\")'><i class='bi bi-trash3'></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' class='text-center'>No orders found.</td></tr>";
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

    <!-- Update Order Modal -->
    <div class="modal fade" id="updateOrderModal" tabindex="-1" aria-labelledby="updateOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content glass-card">
                <div class="modal-header">
                    <h5 class="modal-title text-light" id="updateOrderModalLabel">Update Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateOrderForm" action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="update_order_id" name="order_id">
                        <div class="mb-3">
                            <label for="update_quantity" class="form-label text-light">Quantity</label>
                            <input type="number" class="form-control" id="update_quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_total_price" class="form-label text-light">Total Price</label>
                            <input type="number" class="form-control" id="update_total_price" name="total_price" required readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'js.php'; ?>
    <script>
        function editOrder(orderId, quantity, totalPrice, productPrice) {
            document.getElementById('update_order_id').value = orderId;
            document.getElementById('update_quantity').value = quantity;
            document.getElementById('update_total_price').value = totalPrice; // Initially set total price
            // Update total price when quantity changes
            document.getElementById('update_quantity').setAttribute('data-product-price', productPrice);
            document.getElementById('update_quantity').addEventListener('input', function () {
                const qty = this.value;
                const price = this.getAttribute('data-product-price');
                const newTotalPrice = qty * price; // Calculate new total price
                document.getElementById('update_total_price').value = newTotalPrice.toFixed(2); // Set new total price in the input field
            });
        }
    </script>
</body>

</html>
<?php } else {
    include 'logout.php';
}
?>