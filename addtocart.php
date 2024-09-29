<?php
session_start();

// Ensure 'ROLE' is set in the session before accessing it
$role = isset($_SESSION['ROLE']) ? $_SESSION['ROLE'] : null;

include 'admin/error.php';
include_once('admin/controller/database/db.php'); // Ensure $conn is initialized in this file

// Handle adding products to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addtocart'])) {
    if ($role == 2) {
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);

        // Initialize the cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // Update the quantity
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            // Add the product to the cart
            $_SESSION['cart'][$product_id] = [
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1
            ];
        }

        // Redirect to the cart page
        header("Location: cart.php");
        exit();
    } else {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }
}

// Handle buy action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy'])) {
    if ($role == 2) {
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $user_id = $_SESSION['ID']; // Assuming the user is logged in and their ID is stored in the session

        // Insert the order into the database
        $sql = "INSERT INTO orders (user_id, product_id, quantity, price) 
                VALUES ('$user_id', '$product_id', '$quantity', '$price')";

        if (mysqli_query($conn, $sql)) {
            // Remove item from cart after purchase
            unset($_SESSION['cart'][$product_id]);
            echo 'order placed';
            // header("Location: order_confirmation.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }
}

// Handle delete from cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletefromcart'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Remove the product from the cart
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    // Redirect to the cart page
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrimart</title>
    <?php include 'css.php'; ?>
</head>

<body class="body">
    <div class="container-fluid">
        <nav class="navbar container align-item-center nav-item m-auto navbar-expand-lg mt-3 p-2 mb-3">
            <div class="d-flex  justify-content-center  mt-3">
                <img class="img-logo" src="asset/css/images/logo.png">
            </div>
            <a class="navbar-brand " href="index.php"> Agrimart </a>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item toggle">
                    <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
                </li>
                <li>
                    <a class="nav-link" href="cart.php">Cart
                        (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product.php">Products</a>
                </li>
            </ul>

            <?php if ($role == 2): ?>
            <ul>
                <form class="d-flex">
                    <a class="nav-link text-dark" href="logout.php">Hi, <?php echo ucwords($_SESSION['USERNAME']); ?>
                        <span class="btn text-danger"><i class="bi bi-person-circle"></i> Logout</span></a>
                </form>
            </ul>
            <?php else: ?>
            <ul>
                <li><a class="nav-link" href="login.php"><i class="bi bi-person-plus-fill"></i> Login</a></li>
            </ul>
            <?php endif; ?>
        </nav>

        <div class="row d-flex justify-content-center mt-3">
            <div class="col-md-4 col-sm-12">
                <div class="card d-flex justify-content-center mt-3">
                    <h2>Your Products</h2>
                    <?php if ($role == 2): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="1">
                        <input type="hidden" name="product_name" value="Product A">
                        <input type="hidden" name="product_price" value="10.00">
                    </form>
                    <?php else: ?>
                    <div class="container text-center">
                        <p>Please <a href="login.php">login</a> to add products to your cart.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Display Cart Items if User is Logged In -->
        <?php if ($role == 2 && isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div class="row d-flex justify-content-center mt-3">
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="card">
                            <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                            <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                            <p>Price: ₹<?php echo htmlspecialchars($item['price']); ?></p>
                            <p>Pay: ₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></p>
                            <form method="POST" action="">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>">
                                <input type="hidden" name="quantity"
                                    value="<?php echo htmlspecialchars($item['quantity']); ?>">
                                <input type="hidden" name="price"
                                    value="<?php echo htmlspecialchars($item['price']); ?>">
                                <button type="submit" name="buy" class="btn btn-success">Buy</button>
                            </form>

                            <form method="POST" action="">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>">
                                <button type="submit" name="deletefromcart" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>

</body>

</html>
