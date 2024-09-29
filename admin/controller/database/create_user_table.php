<?php
    $servername="localhost";
    $username="root";
    $password="";
    $database="Agro";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    
    // sql to create Users table
    $sql = "CREATE TABLE users 
    (
        id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fname VARCHAR NOT NULL,
        lname VARCHAR NOT NULL,
        email VARCHAR NOT NULL,
        username VARCHAR NOT NULL,
        pass VARCHAR NOT NULL,
        confirm_password VARCHAR NOT NULL,
        mobile VARCHAR NOT NULL,
        address VARCHAR NOT NULL,
        user_role INT(1) NOT NULL DEFAULT '2'
    )";
    
    if (mysqli_query($conn, $sql)) {
        echo "Table Users created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }
    
    
    mysqli_close($conn);

?>