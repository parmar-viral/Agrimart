<?php include 'breadcrumb.php'; ?>
<?php
session_start();

// Ensure 'ROLE' is set in the session before accessing it
if (isset($_SESSION['ROLE'])) {
    $role = $_SESSION['ROLE'];
} else {
    $role = null; // Or set a default value, or handle the case when the role is not set
}
include 'admin/error.php';
include_once ('admin/controller/database/db.php');
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

    <?php
    // Check the user's role and include the appropriate menu
    if ($role == 2) {
        include 'menu2.php';
    } else {
        include 'menu.php';
    }
    ?>
    <div class="container ">
        <div class="row mt-1">
            <img src="asset/css/images/intro.jpeg" alt="" height="500px" class="intro-img mt-3">
        </div>

        <div class="card mt-3 p-2 mb-3 text text-center">
            <div class="card-header text text-dark text-center">
                <h3>Popular Products</h3>
            </div>
        </div>
        <div class="row mt-1">

            <?php
            $sql = "SELECT * FROM products LIMIT 3";
            $res = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($res)) {
                ?>
            <div class="col-lg-4 col-md-4 col-sm-12 ">
                <div class="card m-1 text-left p-1 ms-2 mb-3">
                    <p class="text-center mt-2">
                        <img src="admin/<?php echo $row['product_image'] ?>" height="160px" width="150px" alt=""
                            srcset="">
                    </p>
                    <h5>
                        <?php echo $row["product_name"]; ?>
                    </h5>

                    <h5>
                        <?php echo '$' . $row["product_price"]; ?>
                    </h5>

                    <h5>
                        <?php echo $row["created_at"]; ?>
                    </h5>
                    <?php
                        // Check the user's role and include the appropriate menu
                        if ($role == 2) {
                          ?>
                    <form class="text-center" method="POST" action="addtocart.php">
                        <input type="hidden" name="role" value="<?php echo $role; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                        <button class="btn m-3" type="submit" name="addtocart">Add-to-Cart</button>
                        <button type="button" value="<?php echo $row['product_id'] ?>" class="btn btn-info"
                            data-bs-target="#display-<?php echo $row['product_id'] ?>" data-bs-toggle="modal">Details
                        </button>
                    </form>
                    <?php
                        } else {                           
                    ?>
                    <form class="text-center" method="POST" action="login.php">
                        <input type="hidden" name="role" value="<?php echo $role; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                        <button class="btn m-3" type="submit" name="addtocart">Add-to-Cart</button>
                        <button type="button" value="<?php echo $row['product_id'] ?>" class="btn btn-info"
                            data-bs-target="#display-<?php echo $row['product_id'] ?>" data-bs-toggle="modal">Details
                        </button>
                    </form>

                    <?php } ?>
                </div>
            </div>

            <div class="modal fade" id="display-<?php echo $row['product_id'] ?>" tabindex="-1"
                aria-labelledby="fordisplaymodal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-center" id="forupdatemodal">Product Information</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row p-2 mt-1">
                                <div class="card col text-left ms-2">
                                    <div class="input-group mb-3">
                                        <img src="admin/<?php echo $row['product_image'] ?>" height="200px"
                                            width="150px" alt="" srcset="">
                                    </div>
                                    <div class="input-group mb-3">
                                        <h5>
                                            Name:
                                        </h5>
                                        <?php echo $row['product_name']; ?>
                                    </div>
                                    <div class="input-group mb-3">
                                        <h5>Description: </h5>
                                        <?php echo $row['description']; ?>
                                    </div>
                                    <div class="input-group mb-3">
                                        <h5>
                                            Price:
                                        </h5>
                                        <?php echo '$' . $row['product_price']; ?>
                                    </div>
                                    <div class="input-group mb-3">
                                        <h5>Created At: </h5>
                                        <?php echo $row['created_at']; ?>
                                    </div>
                                    <div class="input-group mb-3">
                                        <h5>Updated At: </h5>
                                        <?php echo $row['updated_at']; ?>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary text-dark"
                                            data-bs-dismiss="modal">Buy</button>
                                        <form method="POST" action="addtocart.php" class="text-center">
                                            <input type="hidden" name="role" value="<?php echo $role; ?>">
                                            <input type="hidden" name="product_id"
                                                value="<?php echo $row['product_id']; ?>">
                                            <input type="hidden" name="product_name"
                                                value="<?php echo $row['product_name']; ?>">
                                            <input type="hidden" name="product_price"
                                                value="<?php echo $row['product_price']; ?>">
                                            <button class="btn m-3" type="button" name="addtocart"
                                                data-bs-dismiss="modal" value="<?php echo $row["product_id"]; ?>"
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
            ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>

    <script>
    function handleAddToCart(button) {
        var role = button.form.role.value;
        var productId = button.form.product_id.value;

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