<?php
require("admin/controller/database/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lifestyle Store | Settings</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="bootstrap/js/jquery-3.5.0.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <?php include 'css.php'; ?>
</head>
<body>
    <!-- <?php include 'menu2.php'; ?> -->

    <div class="container text text-center">
        <br><br><br><br>
        <div class="row row_style4">
            <div class="col-xs-4 col-xs-offset-4">
                <h1>Change Password</h1>
                <div><b class="text-danger">
                    <?php
                    if (isset($_GET["error"])) {
                        echo $_GET['error'];
                    }
                    ?>
                </b></div>
                <form action="settings_script.php" method="POST">
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Old Password" name="oldpassword" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="New Password" name="newpassword" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Re-type New Password" name="renewpassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
