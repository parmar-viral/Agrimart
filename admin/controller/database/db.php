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