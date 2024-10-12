<?php
session_start();
include 'admin/error.php';


// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    $_SESSION['msg']="You need to login to submit feedback.";
    header("location:login.php");
    exit(); // Ensure the script stops execution after redirecting
}

// Check for a success or error message in session
$msg = null;
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']); // Clear the message from the session after it's been displayed
}
if ($_SESSION['ROLE'] == 2) {
    include_once('admin/controller/feedback_controller.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <?php include 'css.php'; ?>
</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="row d-flex justify-content-center mt-3 mb-3">
        <div class="row">
            <?php if ($msg) { ?>
            <div class="alert alert-info text-center">
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">
                    <div class="card-header text text-dark text-center">
                        <h3>Feedback</h3>
                    </div>
                    <div class="card-body text text-dark">
                        <form method="POST" action="feedback.php">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control mb-3" name="username" id="username"
                                    value="<?php echo $_SESSION['USERNAME']; ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control mb-3" name="email" id="email"
                                    value="<?php echo $_SESSION['EMAIL']; ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control mb-3" name="message" id="message" rows="4"
                                    required></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-center m-3 col-3 p-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
</body>
</html>
<?php } else {
    include 'logout.php';
}