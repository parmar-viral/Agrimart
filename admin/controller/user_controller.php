<?php
class User
{
    public $db;  // Declare the property

    function __construct()
    {
        // Database connection
        $conn = mysqli_connect('localhost', 'root', '', 'Agro');
        $this->db = $conn;  // Initialize the property
        if (mysqli_connect_error()) {
            echo 'Failed to connect: ' . mysqli_connect_error();
        }
    }

    function insert($fname, $lname, $email, $username, $pass, $confirm_password,$mobile, $address, $role)
    {
        $sql = "INSERT INTO `users`(`fname`, `lname`, `email`, `username`, `pass`, `confirm_password`,`mobile`, `address`, `user_role`) 
                VALUES ('$fname', '$lname', '$email', '$username', '$pass','$confirm_password','$mobile', '$address', '$role')";

        $res = mysqli_query($this->db, $sql);
        return $res;
    }

    function update($id, $fname, $lname, $email, $username, $mobile, $address)
    {
        $sql = "UPDATE users SET fname='$fname', lname='$lname', email='$email', username='$username', mobile='$mobile', address='$address' WHERE id='$id'";
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

$obj = new User(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['submit'])) {
    // Get form input data
    $fname = $obj->db->real_escape_string($_POST['fname']);
    $lname = $obj->db->real_escape_string($_POST['lname']);
    $email = $obj->db->real_escape_string($_POST['email']);
    $username = $obj->db->real_escape_string($_POST['username']);
    $pass = $obj->db->real_escape_string(md5($_POST['password']));
    $confirm_password = $obj->db->real_escape_string(md5($_POST['confirmpassword']));
    $mobile = $obj->db->real_escape_string($_POST['mobile']);
    $address = $obj->db->real_escape_string($_POST['address']);
    $role = $obj->db->real_escape_string($_POST['role']);

    // Password matching check
    if ($pass !== $confirm_password) {
        $_SESSION['msg'] = "Passwords do not match. Please try again.";
        exit();
    }

    // Insert user
    $result = $obj->insert($fname, $lname, $email, $username, $pass,$confirm_password, $mobile, $address, $role);

    if ($result) {
        $_SESSION['msg'] = "Registration successful!";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['msg'] = "You are not registered. Please try again.";
    }
}

elseif (isset($_POST['login'])) {
    // Login form handling
    $email = $obj->db->real_escape_string($_POST['email']);
    $username = $obj->db->real_escape_string($_POST['username']);
    $password = $obj->db->real_escape_string(md5($_POST['password']));

    if (!empty($username) && !empty($password) && !empty($email)) {
        // Query to check user existence
        $sql = "SELECT * FROM users WHERE email='$email' AND username='$username' AND pass='$password'";
        $result = mysqli_query($obj->db, $sql);

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            // Fetch user data
            $row = $result->fetch_assoc();
            // Set session variables
            $_SESSION['ID'] = $row['id'];
            $_SESSION['ROLE'] = $row['user_role'];
            $_SESSION['USERNAME'] = $row['username'];
            $_SESSION['EMAIL'] = $row['email'];

            // Redirect based on user role
            if ($row['user_role'] == 0) {  // Admin role
                header("Location: admin/index.php");
            } elseif ($row['user_role'] == 2) {  // Regular user role
                header("Location: index.php");
            }
            exit();
        } else {
            // If no user found
            $_SESSION['msg'] = "Invalid email, username, or password.";
        }
    }
}

elseif (isset($_POST['add_user'])) {
    // Add user functionality for admin
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
        $_SESSION['msg'] = "Passwords do not match.";
        exit();
    }

    $result = $obj->insert($fname, $lname, $email, $username, $pass,$confirm_password, $mobile, $address, $role);

    if ($result) {
        $_SESSION['msg'] = "User added successfully!";
        header("Location: users.php");
        exit();
    } else {
        $_SESSION['msg'] = "Error adding user.";
    }
}

elseif (isset($_POST['update'])) {
    // Update user
    $id = $_POST['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    $res = $obj->update($id, $fname, $lname, $email, $username, $mobile, $address);
    if ($res) {
        $_SESSION['msg'] = "User details updated successfully!";
        header("Location: users.php");
        exit();
    } else {
        $_SESSION['msg'] = "Error updating user.";
    }
}

elseif (isset($_POST['delete'])) {
    // Delete user
    $id = $_POST['user_id'];
    $res = $obj->delete($id);
    if ($res) {
        $_SESSION['msg'] = "User deleted successfully!";
        header("Location: users.php");
        exit();
    } else {
        $_SESSION['msg'] = "Error deleting user.";
    }
}
}
?>