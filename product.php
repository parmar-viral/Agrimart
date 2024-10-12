<?php 
include 'breadcrumb.php'; 
session_start();
include 'admin/error.php';
include_once ('admin/controller/database/db.php');

// Fetch categories for the sidebar
$category_sql = "SELECT * FROM categories";
$category_res = mysqli_query($conn, $category_sql);

// Fetch products based on the selected category (if any)
if (isset($_GET['category_name'])) {
    $selected_category = mysqli_real_escape_string($conn, $_GET['category_name']);
    $product_sql = "SELECT * FROM products WHERE category = '$selected_category'";
} else {
    // Default query to show all products
    $product_sql = "SELECT * FROM products";
}

$res = mysqli_query($conn, $product_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrimart</title>
    <?php include 'css.php'; ?>
</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4 text-center">
                <h2>Shop by Category</h2>
                <div class="category-menu">
                    <?php while($category = mysqli_fetch_assoc($category_res)) { ?>
                        <a href="product.php?category_name=<?php echo $category['category_name']; ?>" class="category-item">
                            <img src="admin/<?php echo htmlspecialchars($category['category_image']); ?>" alt="Category Image">
                            <span><?php echo htmlspecialchars($category['category_name']); ?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <?php if ($res && $res->num_rows > 0) { 
                while ($row = mysqli_fetch_assoc($res)) { ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card m-1 text-left p-1 ms-2 mb-3">
                    <p class="text-center mt-2">
                        <img src="admin/<?php echo htmlspecialchars($row['product_image']); ?>"
                            class="card-img-top mb-3" alt="Product Image"
                            style="height: 220px; object-fit: cover; width: 100%; border-radius:5px">
                    </p>

                    <h5><?php echo htmlspecialchars($row['product_name']); ?></h5>
                    <h5>$<?php echo number_format($row['product_price'], 2); ?></h5>
                    <h5><?php echo htmlspecialchars($row['created_at']); ?></h5>

                    <?php if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == 2) { ?>
                    <form class="text-center" method="POST" action="addtocart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                        <button class="btn m-3" type="submit" name="addtocart">Add-to-Cart</button>
                        <button type="button" class="btn btn-info" data-bs-target="#display-<?php echo $row['product_id'] ?>" data-bs-toggle="modal">Details</button>
                    </form>
                    <?php } else { ?>
                    <form class="text-center" method="POST" action="login.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                        <button class="btn m-3" type="submit" name="addtocart">Add-to-Cart</button>
                        <button type="button" class="btn btn-info" data-bs-target="#display-<?php echo $row['product_id'] ?>" data-bs-toggle="modal">Details</button>
                    </form>
                    <?php } ?>
                </div>
            </div>
            <?php } } else { ?>
            <p>No products found for this category.</p>
            <?php } ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>

</html>
