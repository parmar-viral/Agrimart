<?php

$servername="localhost";
$username="root";
$password="";
$database="Agro";

//create connection

$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}
else{
   // echo "connected";
}

// mysqli_close($conn);

?>


<?php
$sql="CREATE TABLE `cart_items` (
   
    `user_id` INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `product_name` VARCHAR(255) NOT NULL,
    `product_price` DECIMAL(10,2) NOT NULL,
    `quantity` INT NOT NULL,
    `price` DECIMAL(10,2),
    `total_price` DECIMAL(10,2),
     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE
)";
if(mysqli_query($conn,$sql)){
echo 'created';
}
else{
    echo 'Error:';
}

?>