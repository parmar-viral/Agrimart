<?php
include 'db.php';

// Enable error reporting for development (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// SQL to create Users table
$sql = "CREATE TABLE users 
(
    id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    confirm_password VARCHAR(255) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    address VARCHAR(255) NOT NULL,
    user_role INT(1) NOT NULL DEFAULT '2'
)";

if (mysqli_query($conn, $sql)) {
    echo "Table Users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Close the database connection
// mysqli_close($conn);
?>
