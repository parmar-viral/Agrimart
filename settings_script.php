
<?php
session_start();
if (!isset($_SESSION['email'])) { 
    header('location: index.php'); 
    exit(); 
}

require("admin/controller/database/db.php");

$old_pass = $_POST['oldpassword'];
$new_pass = $_POST['newpassword'];
$rep_pass = $_POST['renewpassword'];

// Use prepared statements to prevent SQL injection
$query = $conn->prepare("SELECT password FROM users WHERE email = ?");
$query->bind_param("s", $_SESSION['email']);
$query->execute();
$query->store_result();

if ($query->num_rows > 0) {
    $query->bind_result($orig_pass);
    $query->fetch();

    // Verify the old password
    if (password_verify($old_pass, $orig_pass)) {
        if ($new_pass === $rep_pass) {
            // Hash the new password
            $new_pass_hashed = password_hash($new_pass, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_query = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update_query->bind_param("ss", $new_pass_hashed, $_SESSION['email']);
            $update_query->execute();

            header('location: settings.php?error=Password Updated Successfully');
        } else {
            header('location: settings.php?error=The two passwords don\'t match.');
        }
    } else {
        header('location: settings.php?error=Wrong Old Password.');
    }
} else {
    header('location: settings.php?error=User not found.');
}

$query->close();
$update_query->close();
$con->close();
?>
