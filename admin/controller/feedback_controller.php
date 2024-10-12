<?php
class feedback
{
    public $db;

    function __construct()
    {
        // Establish connection to the database
        $conn = mysqli_connect('localhost', 'root', '', 'Agro');
        $this->db = $conn;
        if (mysqli_connect_error()) {
            echo 'Failed to connect: ' . mysqli_connect_error();
        }
    }

    function insert($name, $email, $message)
    {
        $sql = "INSERT INTO feedback (`user_id`, `name`, `email`, `message`) 
                VALUES ('" . $_SESSION['ID'] . "', '$name', '$email', '$message')";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }

    function update($user_id, $name, $email, $message)
    {
        $sql = "UPDATE feedback SET name='$name', email='$email', message='$message' WHERE user_id='$user_id'";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }

    function delete($user_id)
    {
        $sql = "DELETE FROM feedback WHERE `user_id`='$user_id'";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }

    function view()
    {
        $sql = "SELECT * FROM feedback";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }
}

$obj = new feedback();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $name = $_POST['username'];
        $email = $_POST['email'];
        $message = $_POST['message'];
    
        $res = $obj->insert($name, $email, $message);
        if ($res) {
            $_SESSION['msg'] = "Feedback inserted successfully!";
        } else {
            $_SESSION['msg'] = "error to send feedback";
        }
        header("location:feedback.php");
        exit();
    }elseif (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $res = $obj->update($user_id, $name, $email, $message);
    if ($res) {
        $_SESSION['msg'] = "Feedback updated successfully!";
    } else {
        $_SESSION['msg'] = "Error updating feedback.";
    }
    header("location:feedback.php");
    exit();
}elseif (isset($_POST['delete'])) {
    $user_id = $_POST['id'];
    $res = $obj->delete($user_id);
    if ($res) {
        $_SESSION['msg'] = "Feedback deleted successfully!";
    } else {
        $_SESSION['msg'] = "Error deleting feedback.";
    }
    header("location:feedback.php");
    exit();
}
}
?>