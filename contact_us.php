<?php

session_start();

// Ensure 'ROLE' is set in the session before accessing it
if (isset($_SESSION['ROLE'])) {
    $role = $_SESSION['ROLE'];
} else {
    $role = null; // Or set a default value, or handle the case when the role is not set
}

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
    <title>Contact Us</title>
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
    
    <div class="row  d-flex  justify-content-center  mt-3 mb-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">
                    <div class="card-header text text-dark text-center">
                        <h3>Contact Us</h3>
                    </div>

                    <div class="card-body text text-dark">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="name" class="mb-2">Name</label>
                                <input type="text" class="form-control mb-3" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="mb-2">Email</label>
                                <input type="email" class="form-control mb-3" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="mobileno" class="mb-2">Mobile No</label>
                                <input type="number" class="form-control mb-3" id="mobileno" name="mobileno" required>
                            </div>
                            <div class="form-group">
                                <label for="message" class="mb-2">Message</label>
                                <textarea class="form-control mb-3" id="message" name="message" rows="5"
                                    required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-center m-3 col-3 p-2">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container-fluid">

        <div class="row  d-flex  justify-content-center  mt-3">
            <div class="col-md-4  col-sm-12">
                <form class="mt-3 aline-item-center form p-2 mb-3" action="" method="POST">
                    <div class="text text-center text-dark mb-3">
                        <h3>Contact Us</h3>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="name">Name</span>
                        <input type="text" name="name" class="m-1 p-2" placeholder="Name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="email">Email</span>
                        <input type="email" name="email" class="m-1 p-2" placeholder="Email">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="message">Message</span>
                        <textarea name="message" rows="4" required></textarea>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" name="submit" class="btn">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
    <?php include 'footer.php';?>
    <?php include 'js.php'; ?>
</body>

</html>