<?php
include 'admin/error.php';
session_start();
include_once('admin/controller/database/db.php');

$errorMsg = "";

if (isset($_POST['submit'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string(md5($_POST['password']));

    if (!empty($username) && !empty($password) && !empty($email)) {
        // Query to check if the user exists with the provided email, username, and password
        $sql = "SELECT * FROM users WHERE email='$email' AND username='$username' AND pass='$password'";
        $result = mysqli_query($conn, $sql);
        
        // Check if any rows are returned
        if ($result->num_rows > 0) {
            // Fetch user data
            $row = $result->fetch_assoc();
            // Set session variables
            $_SESSION['ID'] = $row['id'];
            $_SESSION['ROLE'] = $row['user_role'];
            $_SESSION['USERNAME'] = $row['username'];
            
            // Redirect based on user role
            if ($row['user_role'] == 0 || $row['user_role'] == 1) {
                header("Location:admin/index.php");
            } elseif ($row['user_role'] == 2) {
                header("Location:index.php");
                exit();
            }
            die();
        } else {
            // If no user found, set error message
            $errorMsg = "Invalid email, username, or password.";
        }
    } else if(empty($username) && !empty($password) && !empty($email)){
        $errorMsg = "Username is required.";
    }
    else if(!empty($username) && empty($password) && !empty($email)){
        $errorMsg = "Password is required.";
    }
    else if(!empty($username) && !empty($password) && empty($email)){
        // If any field is empty, set error message
        $errorMsg = "Email is required.";
    }
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
            <div class="col-md-4 col-sm-12">
                <div class="d-flex justify-content-center mt-3">
                    <img class="logo" src="asset/css/images/admin-logo.png" alt="Logo">
                </div>
                <form class="mt-3 text-center card p-2 mb-3" action="" method="POST" id="loginForm">
                    <div class="text text-center text-dark">
                        <h3>Login</h3>
                    </div>
                    <?php
                    // Display error message if it is set
                    if (!empty($errorMsg)) {
                        echo "<div class='alert alert-danger' role='alert'>$errorMsg</div>";
                    }
                    ?>
                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="email"><i class="bi bi-envelope-at"></i></span>
                        <input type="email" name="email" class="form-control line-input m-1 p-2" placeholder="Email" id="email" >
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="username"><i class="bi bi-person-circle"></i></span>
                        <input type="text" name="username" class="form-control line-input m-1 p-2" placeholder="Username" id="username" >
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text m-1 p-2" id="password"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="password" class="form-control line-input m-1 p-2" placeholder="Password" id="password" >
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" name="submit" class="btn btn-primary text-dark col-3">Login</button>
                    </div>
                    <div class="mb-3 text-center text-dark">
                        <h4>Don't have an account? <a href="signup.php" class="btn text text-primary"> Signup</a></h4>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>

</html>
