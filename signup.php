<?php
include 'admin/error.php';
include 'admin/controller/database/db.php';
include 'admin/controller/user_controller.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrimart</title>
    <?php include 'css.php'; ?>
    <script src="asset/js/signup.js" defer></script>
</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="row d-flex justify-content-center mt-3 mb-3">
        <div class="col-md-6">
            <div class="card mb-3 mt-3">
                <div class="card-header text-center">
                    <h3>Register Here</h3>
                </div>
                <div class="card-body">
                    <form class="mt-3 mb-3 p-2" action="" method="POST" id="signupForm">
                        <div class="input-group mb-3">
                            <span class="input-group-text m-1 p-2" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
                            <input type="text" name="fname" id="fname" class="m-1 p-2 form-control" placeholder="Name" required>
                            <span id="nameError" class="error"></span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text m-1 p-2" id="basic-addon2"><i class="bi bi-person-circle"></i></span>
                            <input type="text" name="lname" id="lname" class="m-1 p-2 form-control" placeholder="Surname" required>
                            <span id="surnameError" class="error"></span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text m-1 p-2" id="email-addon"><i class="bi bi-envelope-at"></i></span>
                            <input type="email" name="email" id="email" class="m-1 p-2 form-control" placeholder="Email" required>
                            <span id="emailError" class="error"></span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text m-1 p-2" id="username-addon"><i class="bi bi-person-circle"></i></span>
                            <input type="text" name="username" id="username" class="m-1 p-2 form-control" placeholder="Username" required>
                            <span id="usernameError" class="error"></span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text m-1 p-2" id="password-addon"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="password" id="password" class="m-1 p-2 form-control" placeholder="Password" required minlength="6">
                            <span id="passwordError" class="error"></span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text m-1 p-2" id="confirmpassword-addon"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="confirmpassword" id="confirmpassword" class="m-1 p-2 form-control" placeholder="Confirm Password" required>
                            <span id="confirmPasswordError" class="error"></span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text m-1 p-2" id="mobile-addon"><i class="bi bi-telephone-fill"></i></span>
                            <input type="tel" name="mobile" id="mobile" class="m-1 p-2 form-control" placeholder="Mobile No" required>
                            <span id="mobileError" class="error"></span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text m-1 p-2" id="address-addon"><i class="bi bi-house"></i></span>
                            <textarea class="form-control p-2 ms-1" name="address" id="address" cols="36" rows="3" placeholder="Address"></textarea>
                        </div>
                        <input type="hidden" name="role" value="2">
                        <div class="mb-3 text-center">
                            <button type="submit" name="submit" class="btn col-3">Sign Up</button>
                        </div>
                        <div class="mb-3 text-center text-black">
                            <h4>Already have an account? <a href="login.php" class="text-primary col-2 btn">Login</a></h4>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>

</html>
