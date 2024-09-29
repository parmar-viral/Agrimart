<?php
session_start();

// Ensure 'ROLE' is set in the session before accessing it
if (isset($_SESSION['ROLE'])) {
    $role = $_SESSION['ROLE'];
} else {
    $role = null; // Or set a default value, or handle the case when the role is not set
}

include 'admin/error.php';
include_once('admin/controller/database/db.php');
?>

<?php

// Check if the user is logged in
$userLoggedIn = isset($_SESSION['user']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addtocart'])) {
    if ($role == 2) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];

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

        // Redirect to the cart page or back to the product page
        header("Location: cart.php");
        exit();
    } else {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }
}

// Handle delete from cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletefromcart'])) {
    $product_id = $_POST['product_id'];

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
    <style>
        /* Responsive Glass Effect Styling */
        .glass {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin: 10px 0;
        }
        .card {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }
        .card h4 {
            margin-bottom: 10px;
        }
        .card button {
            margin: 5px;
        }

        /* Responsive menu with glass effect */
        nav {
            background: rgba(255, 255, 255, 0.25);
            padding: 10px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        nav ul li {
            margin: 5px 0;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        nav ul li a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            .card {
                margin: 10px 0;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body class="body">
<div class="container-fluid">
    <nav class="navbar container align-item-center nav-item  m-auto navbar-expand-lg mt-3 p-2 mb-3">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item toggle">
                <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
            </li>
            <li>
                <a class="nav-link" href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="product.php">Products</a>
            </li>
        
        </ul>
        
            <?php
            include 'admin/error.php';
            if ($role==2) { ?>
            <ul>
                <form class="d-flex">
                    <a class="nav-link text-dark" href="logout.php">Hi, <?php echo ucwords($_SESSION['USERNAME']); ?>
                        <span class="btn text-danger"><i class="bi bi-person-circle"></i> Logout</span></a>
                </form>
                </ul>
                </nav>
            <?php } ?>
            <!-- <?php if ($role == 2): ?>
                <li><a class="nav-link" href="logout.php">Logout</a></li> --> 
            <?php else: ?>
                <ul>
                <li><a class="nav-link" href="login.php">Login</a></li>
                <li><a class="nav-link" href="signup.php">Register</a></li>
                </ul>
            <?php endif; ?>
        
    </nav>

    <div class="row d-flex justify-content-center mt-3">
        <div class="col-md-4 col-sm-12">
            <div class="glass d-flex justify-content-center mt-3">
                <h2>Your Products</h2>
                <!-- Example product form -->
                <?php if ($role == 2): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="1">
                        <input type="hidden" name="product_name" value="Product A">
                        <input type="hidden" name="product_price" value="10.00">
                    </form>
                    </div>
                <?php else:{ ?>
                    <div class="container text-center">
                    <p>Please <a href="login.php">login</a> to add products to your cart.</p>

                    </div>
                <?php }endif; ?>
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
                                <h4><?php echo $item['name']; ?></h4>
                                <p>Quantity: <?php echo $item['quantity']; ?></p>
                                <p>Price: ₹<?php echo $item['price']; ?></p>
                                <p>Pay: ₹<?php echo $item['price']*$item['quantity'];?></p>
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="buy" class="btn btn-success">Buy</button>
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
