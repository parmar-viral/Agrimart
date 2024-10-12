<?php
session_start();
include 'controller/database/db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['ID'])) {
    header("Location: logout.php");
    exit();
}
if ($_SESSION['ROLE'] == 0) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include 'css.php'; ?>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <!-- Content area -->
    <div class="content">
        <div class="container mt-5">
            <div class="row">
                <?php 

// Fetch some data for the dashboard (example: total users, total categories)
$query = "SELECT COUNT(*) as total_users FROM users";
$result = $conn->query($query);
$totalUsers = $result->fetch_assoc()['total_users'];

$query = "SELECT COUNT(*) as total_categories FROM categories";
$result = $conn->query($query);
$totalCategories = $result->fetch_assoc()['total_categories'];

$query = "SELECT COUNT(*) as total_products FROM products";
$result = $conn->query($query);
$totalProducts = $result->fetch_assoc()['total_products'];
            ?>
                <!-- Card for Total Users -->
                <div class="col-lg-4 mb-4">
                    <div class="card glass-card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text display-4"><?php echo htmlspecialchars($totalUsers); ?></p>
                            <a href="users.php" class="btn btn-primary">Manage Users</a>
                        </div>
                    </div>
                </div>

                <!-- Card for Total Categories -->
                <div class="col-lg-4 mb-4">
                    <div class="card glass-card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories</h5>
                            <p class="card-text display-4"><?php echo htmlspecialchars($totalCategories); ?></p>
                            <a href="category.php" class="btn btn-primary">Manage Categories</a>
                        </div>
                    </div>
                </div>

                <!-- Additional Card (Example: Total Products) -->
                <div class="col-lg-4 mb-4">
                    <div class="card glass-card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text display-4"><?php echo htmlspecialchars($totalProducts); ?></p>
                            <a href="products.php" class="btn btn-primary">Manage Products</a>
                        </div>
                    </div>
                </div>

                <!-- Add more cards as needed -->
                <div class="col-lg-4 mb-4">
                    <div class="card glass-card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Analytics</h5>
                            <p class="card-text">
                            <h5>View Stats</h5>
                            </p> <!-- Example static value -->
                            <a href="analytics.php" class="btn btn-primary">View Analytics</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'js.php'; // Include JavaScript files ?>
</body>

</html>
<?php } else {
    include 'logout.php';
}
?>