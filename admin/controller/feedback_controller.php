<?php
class feedback
{
    public $db;

    function __construct()
    {        
        $conn = mysqli_connect('localhost', 'root', '', 'Agro');
        $this->db = $conn;
        if (mysqli_connect_error()) {
            echo 'Failed to connect: ' . mysqli_connect_error();
        }
    }

    function insert($name, $email, $message)
    {
        // Correct the SQL query and log it for debugging
        $sql = "INSERT INTO feedback (user_id, name, email, message) VALUES ('" . $_SESSION['ID'] . "', '$name', '$email', '$message')";
        
        // Print the SQL query for debugging
        echo "Executing query: $sql";

        $res = mysqli_query($this->db, $sql);
        
        // Check for SQL errors
        if (!$res) {
            echo "SQL Error: " . mysqli_error($this->db);
        }

        return $res;
    }

    function update()
    {
        $sql = "";
        $res = mysqli_query($this->db, $sql);
        return $res;
    }

    function delete($user_id)
    {
        $sql = "DELETE FROM feedback WHERE user_id='$user_id'";
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

// Check if session variables are correctly set
if (!isset($_SESSION['ID']) || !isset($_SESSION['USERNAME']) || !isset($_SESSION['EMAIL'])) {
    echo "<script>alert('Session variables are not set. Please log in.'); window.location.href = 'login.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate if the submitted email and username match the logged-in user
    if ($username != $_SESSION['USERNAME'] || $email != $_SESSION['EMAIL']) {
        echo "<script>alert('You can only submit feedback using your registered username and email.'); window.location.href = 'login.php';</script>";
    } else {
        // Insert feedback and handle result
        $res = $obj->insert($username, $email, $message);
        if ($res) {
            echo "<script>alert('Feedback submitted successfully!'); window.location.href = 'feedback.php';</script>";
        } else {
            echo "<script>alert('Error submitting feedback.');</script>";
            echo "SQL Error: " . mysqli_error($obj->db); // Display the SQL error for debugging
        }
    }
} elseif (isset($_POST['update'])) {
    $res = $obj->update();
    if ($res) {
        echo "<script>alert('Feedback updated successfully!'); window.location.href = 'feedback.php';</script>";
    } else {
        echo "<script>alert('Feedback not updated successfully');</script>";
    }
} elseif (isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];
    $res = $obj->delete($user_id);
    if ($res) {
        echo "<script>alert('Feedback deleted successfully!'); window.location.href = 'feedback.php';</script>";
    } else {
        echo "<script>alert('Feedback not deleted successfully');</script>";
    }
}
?>
