<?php

$servername="localhost";
$username="root";
$password="";

//create connection

$conn=mysqli_connect($servername,$username,$password);
if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

//create database

$sql="CREATE DATABASE Agro";
$result=mysqli_query($conn,$sql);
if($result)
{
    echo "database created successfully";
}
else{
    die("failed to create database".mysqli_error($conn));
}


mysqli_close($conn);

?>