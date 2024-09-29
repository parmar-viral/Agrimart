<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Agro";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to create category table
$sql="CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if(mysqli_query($conn, $sql)) {
    echo "Table category created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}


//sql to create feedback table
$sql = "CREATE TABLE feedback (
        name VARCHAR(255)NOT NULL,
        email VARCHAR(255)NOT NULL,
        message VARCHAR(255)NOT NULL
        
    )";
if (mysqli_query($conn, $sql)) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}


mysqli_close($conn);

?>