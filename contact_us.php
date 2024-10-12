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

$errorMsg = ""; // Initialize error message
$successMsg = ""; // Initialize success message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobileno = trim($_POST['mobileno']);
    $message = trim($_POST['message']);

    // Example: Sending email (you might need to configure your mail settings)
    $to = "parmarviral8324@gmail.com"; // Replace with your support email
    $subject = "Contact Us Form Submission";
    $body = "Name: $name\nEmail: $email\nMobile No: $mobileno\nMessage: $message";
    $headers = "From: $email";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        $_SESSION['success_msg'] = "Thank you! Your message has been sent."; // Store success message
        header("Location: ".$_SERVER['PHP_SELF']); // Redirect to the same page
        exit(); // Ensure script ends after redirection
    } else {
        $_SESSION['error_msg'] = "Sorry! There was an issue sending your message. Please try again later."; // Store error message
    }
}

// Display messages if they are set
if (isset($_SESSION['success_msg'])) {
    $successMsg = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']); // Clear the message after displaying
}

if (isset($_SESSION['error_msg'])) {
    $errorMsg = $_SESSION['error_msg'];
    unset($_SESSION['error_msg']); // Clear the message after displaying
}
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
    <?php include 'menu.php'; ?>

    <div class="row d-flex justify-content-center mt-3 mb-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">
                    <div class="card-header text text-dark text-center">
                        <h3>Contact Us</h3>
                    </div>

                    <div class="card-body text text-dark">
                        <div class="contact">
                            <?php if (!empty($successMsg)): ?>
                                <div class='alert alert-success'><?= $successMsg; ?></div>
                            <?php endif; ?>

                            <?php if (!empty($errorMsg)): ?>
                                <div class='alert alert-danger'><?= $errorMsg; ?></div>
                            <?php endif; ?>

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
                                    <textarea class="form-control mb-3" id="message" name="message" rows="5" required></textarea>
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
        <?php include 'footer.php';?>
        <?php include 'js.php'; ?>

        <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const email = document.getElementById('email').value;
            const mobile = document.getElementById('mobileno').value;

            if (!email.includes('@')) {
                alert('Please enter a valid email address.');
                event.preventDefault();
            }

            if (mobile.length != 10) {
                alert('Please enter a valid 10-digit mobile number.');
                event.preventDefault();
            }
        });
        </script>

</body>
</html>
