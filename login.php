<?php
include 'admin/error.php';
session_start();
include_once('admin/controller/database/db.php');
include_once('admin/controller/user_controller.php');
// Check for a success or error message in session
$msg = null;
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']); // Clear the message from the session after it's been displayed
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include 'css.php'; ?>
    <script src="asset/js/login.js" defer></script>
</head>

<body>

    <?php include 'menu.php';?>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center mt-3">
            <?php if ($msg) { ?>
            <div class="alert alert-info text-center">
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="col-md-4 col-sm-12">
                <div class="d-flex justify-content-center mt-3">
                    <img class="logo" src="asset/css/images/admin-logo.png" alt="Logo">
                </div>
                <form class="mt-3 text-center card p-2 mb-3" action="" method="POST" id="loginForm">
                    <div class="card-header text-center mb-3">
                        <h3>Login Here</h3>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="email"><i class="bi bi-envelope-at"></i></span>
                        <input type="email" name="email" class="form-control line-input m-1 p-2" placeholder="Email"
                            id="email">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="username"><i class="bi bi-person-circle"></i></span>
                        <input type="text" name="username" class="form-control line-input m-1 p-2"
                            placeholder="Username" id="username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="password"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="password" class="form-control line-input m-1 p-2"
                            placeholder="Password" id="password">
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" name="login" class="btn col-3">Login</button>
                    </div>
                    <div class="mb-3 text-center text-dark">
                        <h4>Don't have an account? <a href="register.php" class="btn"> Register</a></h4>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>

</html>