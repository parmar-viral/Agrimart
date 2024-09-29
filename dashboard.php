<?php 
include 'admin/error.php';
session_start();
// Include database connection file
include_once('admin/controller/database/db.php');
if (!isset($_SESSION['ID'])) {
    header("Location:login.php");
    exit();
}
if(2==$_SESSION['ROLE']){
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
    <?php include 'menu2.php'; ?>

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
            $sql = "SELECT * FROM products";
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
                    <form action="addtocart.php" method="POST" class="text-center">
                        <button class="btn m-3" type="submit" name="product_id"
                            value="<?php echo $row["product_id"]; ?>">addtocart</button>

                        <button type="button" class="btn " data-bs-target="#display-<?php echo $row['product_id'] ?>" data-bs-toggle="modal">Details
                        </button>
                    </form>
                </div>
                <div class="modal fade" id="display-<?php echo $row['product_id'] ?>" tabindex="-1" aria-labelledby="fordisplaymodal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 text-center" id="forupdatemodal">Product Information</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>

                            </div>
                            <div class="modal-body">
                                <div class="row p-2 mt-1">
                                    <div class=" card col text-left ms-2">
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
                                            <?php echo '$'. $row['product_price']; ?>

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
                                            <form action="addtocart.php" method="POST" class="text-center">
                                                <button class="btn m-3" type="submit" name="product_id"
                                                    data-bs-dismiss="modal"
                                                    value="<?php echo $row["product_id"]; ?>">addtocart</button>


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
            </div>
            <?php }
            ?>
        </div>

    </div>
    <?php include 'footer.php';?>


    <?php include 'js.php'; ?>
</body>

</html>
<?php } else {
    session_destroy();
    header("Location:dashboard.php");
    exit();
}
?>
