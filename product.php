<?php 
include 'breadcrumb.php'; 
session_start();
include 'admin/error.php';
include_once ('admin/controller/database/db.php');

// Fetch categories for the sidebar
$category_sql = "SELECT * FROM categories";
$category_res = mysqli_query($conn, $category_sql);

// Fetch products based on the selected category (if any)
if (isset($_GET['category'])) {
    $selected_category = mysqli_real_escape_string($conn, $_GET['category']);
    $product_sql = "SELECT * FROM products WHERE category = '$selected_category'";
} else {
    // Default query to show all products
    $product_sql = "SELECT * FROM products";
}

$product_res = mysqli_query($conn, $product_sql);
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
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar glass">
                <h4>Categories</h4>
                <ul>
                    <?php
                if ($category_res->num_rows > 0) {
                    while ($cat_row = mysqli_fetch_assoc($category_res)) {
                        echo '<li><a href="product.php?category=' . urlencode($cat_row['category_name']) . '">' . $cat_row['category_name'] . '</a></li>';
                    }
                } else {
                    echo '<li>No categories found.</li>';
                }
                ?>
                </ul>
            </div>

            <!-- Product Listings -->
            <div class="col-md-9">
                <div class="row mt-1 products">
                    <?php
                if ($product_res && $product_res->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($product_res)) {
                        ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 products-grid">
                        <div class="card m-1 text-left p-1 ms-2 mb-3">
                            <p class="text-center mt-2">
                                <img src="admin/<?php echo $row['product_image'] ?>" height="150px" width="150px"
                                    alt="">
                            </p>
                            <h5><?php echo $row["product_name"]; ?></h5>
                            <h5><?php echo '$' . $row["product_price"]; ?></h5>
                            <h5><?php echo $row["created_at"]; ?></h5>
                            <?php if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == 2) { ?>
                            <form class="text-center" method="POST" action="addtocart.php">
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                                <button class="btn m-3" type="submit" name="addtocart">Add-to-Cart</button>
                                <button type="button" class="btn btn-info"
                                    data-bs-target="#display-<?php echo $row['product_id'] ?>"
                                    data-bs-toggle="modal">Details</button>
                            </form>
                            <?php } else { ?>
                            <form class="text-center" method="POST" action="login.php">
                                <input type="hidden" name="redirect"
                                    value="product.php?category=<?php echo urlencode($selected_category); ?>">
                                <button class="btn m-3" type="submit" name="addtocart">Add-to-Cart</button>
                                <button type="button" class="btn btn-info"
                                    data-bs-target="#display-<?php echo $row['product_id'] ?>"
                                    data-bs-toggle="modal">Details</button>
                            </form>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Modal for Product Details -->
                    <div class="modal fade" id="display-<?php echo $row['product_id'] ?>" tabindex="-1"
                        aria-labelledby="fordisplaymodal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-center">Product Information</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row p-2 mt-1">
                                        <div class="card col text-left ms-2">
                                            <div class="input-group mb-3">
                                                <img src="admin/<?php echo $row['product_image'] ?>" height="200px"
                                                    width="150px" alt="">
                                            </div>
                                            <div class="input-group mb-3">
                                                <h5>Name:</h5>
                                                <?php echo $row['product_name']; ?>
                                            </div>
                                            <div class="input-group mb-3">
                                                <h5>Description:</h5>
                                                <?php echo $row['description']; ?>
                                            </div>
                                            <div class="input-group mb-3">
                                                <h5>Price:</h5>
                                                <?php echo '$' . $row['product_price']; ?>
                                            </div>
                                            <div class="input-group mb-3">
                                                <h5>Created At:</h5>
                                                <?php echo $row['created_at']; ?>
                                            </div>
                                            <div class="input-group mb-3">
                                                <h5>Updated At:</h5>
                                                <?php echo $row['updated_at']; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary text-dark"
                                                    data-bs-dismiss="modal">Buy</button>
                                                <form method="POST" action="addtocart.php" class="text-center">
                                                    <input type="hidden" name="product_id"
                                                        value="<?php echo $row['product_id']; ?>">
                                                    <input type="hidden" name="product_name"
                                                        value="<?php echo $row['product_name']; ?>">
                                                    <input type="hidden" name="product_price"
                                                        value="<?php echo $row['product_price']; ?>">
                                                    <button class="btn m-3" type="button"
                                                        onclick="handleAddToCart(this)">Add-to-Cart</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary text-dark"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }
                } else {
                    echo "<p>No products found for this category.</p>";
                } ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>

    <script>
    function handleAddToCart(button) {
        const role = <?php echo json_encode(isset($_SESSION['ROLE']) ? $_SESSION['ROLE'] : null); ?>;
        const productId = button.closest('form').product_id.value;

        if (role) {
            // If the user is logged in, redirect to addtocart page
            window.location.href = 'addtocart.php?product_id=' + productId;
        } else {
            // If the user is not logged in, redirect to the login page
            window.location.href = 'login.php';
        }
    }
    </script>
</body>

</html>