<?php

class user
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
    function insert($fname, $lname, $email, $username, $pass, $confirm_password, $mobile, $address, $role)
    {
        $sql = "INSERT INTO `users`(`fname`,`lname`,`email`,`username`,`pass`,`confirm_password`,`mobile`,`address`,`user_role`) 
            VALUES ('$fname','$lname','$email','$username','$pass','$confirm_password','$mobile','$address','$role')";

        $res = mysqli_query($this->db, $sql);
        return $res;
    }
    
    function update($id,$fname,$lname,$email,$username,$mobile,$address)
    {
        $sql = "UPDATE users SET fname='$fname', lname='$lname', email='$email',username='$username', mobile='$mobile',address='$address' WHERE id='$id'";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }
    function delete($id)
    {
        $sql = "DELETE FROM `users` WHERE `id`='$id'";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }
    function view()
    {

        $sql = "SELECT * FROM `users`";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }
}
$obj = new user();
if (isset($_POST['submit'])) {
    $fname = $obj->db->real_escape_string($_POST['fname']);
    $lname = $obj->db->real_escape_string($_POST['lname']);
    $email = $obj->db->real_escape_string($_POST['email']);
    $username = $obj->db->real_escape_string($_POST['username']);
    $pass = $obj->db->real_escape_string(md5($_POST['password']));
    $confirm_password = $obj->db->real_escape_string(md5($_POST['confirmpassword']));
    $mobile = $obj->db->real_escape_string($_POST['mobile']);
    $address = $obj->db->real_escape_string($_POST['address']);
    $role = $obj->db->real_escape_string($_POST['role']);

    if ($pass !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
        exit();
    }

    $result = $obj->insert($fname, $lname, $email, $username, $pass, $confirm_password, $mobile, $address, $role);

    if ($result) {
        $_SESSION['message'] = "Registration successful!";
        
        header("Location: login.php");
        exit();
    } else {
        echo "You are not registered. Please try again.";
    }
}
elseif (isset($_POST['update'])) {
    $id = $_POST['user_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];

    $res = $obj->update($id,$fname,$lname,$email,$username,$mobile,$address);
    if ($res) {
        $_SESSION['msg'] = "User details updated successfully!";
        header("Location: users.php"); // Redirect to the same page
        exit();
 
    } else {
        $msg = "Error updating record: " . mysqli_error($conn);
    }
} 
 elseif (isset($_POST['delete'])) {
    $id = $_POST['user_id'];
    $res = $obj->delete($id);
    if ($res) {
        header("location:users.php");
    } else {
        echo "not deleted";
    }
}
?>