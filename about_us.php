<?php
session_start();
// Include other necessary files and handle other logic
include 'admin/error.php';
include_once('admin/controller/database/db.php');
include 'breadcrumb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <?php include 'css.php';  ?>

</head>

<body>
    <?php include 'menu.php';  ?>
    <div class="row  d-flex  justify-content-center  mt-3 mb-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">


                    <div class="card-header text text-dark text-center">
                        <h3>About Us</h3>
                    </div>

                    <div class="card-body text text-dark">
                        <p>Welcome to our online shop! We specialize in providing the best agricultural products.</p>
                        <p>Our mission is to support farmers and deliver high-quality products to our customers.</p>
                        <p>With years of experience in the industry, we strive to offer a wide range of products that
                            meet the needs of our diverse clientele.</p>
                        <p>Thank you for choosing us. We look forward to serving you!<a href="details.php">Read
                                More..</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php';?>
    <?php include 'js.php';  ?>
</body>

</html>