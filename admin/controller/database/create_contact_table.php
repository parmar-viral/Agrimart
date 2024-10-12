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
    $sql = "CREATE TABLE contact
    (
        id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
       
        email VARCHAR(255) NOT NULL,
        
        mobile VARCHAR(10) NOT NULL,
        address VARCHAR(300) NOT NULL
        
    )";
    
    if (mysqli_query($conn, $sql)) {
        echo "Table contact created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }
    
