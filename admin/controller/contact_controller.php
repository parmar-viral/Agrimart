<?php

class contact
{
    public $db;  // Declare the property

    function __construct()
    {
        $conn = mysqli_connect('localhost', 'root', '', 'Agro');
        $this->db = $conn;  //Initialize the property
        if (mysqli_connect_error()) {
            echo 'failed to connect' . mysqli_connect_error();
        }
    }
    function insert($name, $email, $mobile, $address)
    {
        $sql = "INSERT INTO `users`(`fname`,`lname`,`email`,`username`,`pass`,`confirm_password`,`mobile`,`address`,`user_role`) 
            VALUES ('$name','$email','$mobile','$address')";

        $res = mysqli_query($this->db, $sql);
        return $res;
    }
    /*
    function update()
    {
        $sql = "UPDATE `users` SET ``='' WHERE `id`=''";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }*/
    function delete($id)
    {
        $sql = "DELETE FROM `contact` WHERE `id`='$id'";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }
    function view()
    {

        $sql = "SELECT * FROM `contact`";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }
}
$obj = new contact();
if (isset($_POST['submit'])) {
    $name = $obj->db->real_escape_string($_POST['name']);
    $email = $obj->db->real_escape_string($_POST['email']);
    $mobile = $obj->db->real_escape_string($_POST['mobile']);
    $address = $obj->db->real_escape_string($_POST['address']);

    
    $result = $obj->insert($name, $email,  $mobile, $address);

    if ($result) {
        $_SESSION['message'] = "Thank you";
        header("Location: index.php");
        exit();
    } else {
        echo " Please try again.";
    }
}

/*
if (isset($_POST['update'])) {
    $id = $_POST['user_id'];
    $course = $_POST[''];

    $res = $obj->update();
    if ($res) {
        header("location:users.php");
    } else {
        echo "alert('data not updated successfully')";
    }
} */ elseif (isset($_POST['delete'])) {
    $id = $_POST['user_id'];
    $res = $obj->delete($id);
    if ($res) {
        header("location:contact_us.php");
    } else {
        echo "not deleted";
    }
}
?>