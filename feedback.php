<?php
session_start();

// Include necessary files and handle other logic
include 'admin/error.php';
include_once('admin/controller/database/db.php'); // Ensure this is properly included

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    echo "<script>alert('You need to log in to submit feedback.'); window.location.href = 'login.php';</script>";
    exit(); // Ensure the script stops execution after redirecting
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate if the submitted email and username match the logged-in user
    if ($username != $_SESSION['USERNAME'] || $email != $_SESSION['EMAIL']) {
        echo "<script>alert('You can only submit feedback using your registered username and email.');</script>";
    } else {
        // Insert feedback into the database
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, name, email, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $_SESSION['ID'], $username, $email, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Feedback submitted successfully!');</script>";
        } else {
            echo "<script>alert('Error submitting feedback.');</script>";
        }

        $stmt->close();
    }
}

// Close the database connection
mysqli_close($conn);
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
            <div class="col-md-6 offset-md-3">
                <div class="card mb-2">
                    <div class="card-header text text-dark text-center">
                        <h3>Feedback</h3>
                    </div>
                    <div class="card-body text text-dark">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control mb-3" name="username" id="username" value="<?php echo $_SESSION['USERNAME']; ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control mb-3" name="email" id="email" value="<?php echo $_SESSION['EMAIL']; ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control mb-3" name="message" id="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-center m-3 col-3 p-2">Submit</button>
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
