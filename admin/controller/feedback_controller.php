<?php 
class feedback
    {
        public $db;  // Declare the property

        function __construct(){        
            $conn=mysqli_connect('localhost','root','','Agro');
            $this->db=$conn; //Initialize the property
            if(mysqli_connect_error()){
                echo 'failed to connect'.mysqli_connect_error();
            }
        }
        function insert($name,$email,$message)
        {
            $sql  = "INSERT INTO feedback (user_id, name, email, message) VALUES ('".$_SESSION['ID']."', '$name', '$email', '$message')";       
            $res=mysqli_query($this->db,$sql);
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
            $sql = "DELETE FROM `feedback` WHERE `user_id`='$user_id'";
            $res = mysqli_query($this->db, $sql);
            return $res;
        }
        function view()
        {
                
            $sql = "SELECT * FROM `feedback`";
            $res = mysqli_query($this->db,$sql);
            return $res;
        }
    }
    $obj = new feedback();

if (isset($_POST['submit'])) {
        // Escape user inputs to prevent SQL injection
    $name =$conn->mysqli_real_escape_string($_POST['name']);
    $email = $conn->mysqli_real_escape_string($_POST['email']);
    $message = $conn->mysqli_real_escape_string($_POST['message']);
    $res=$obj->insert($name,$email,$message);
  
    // Check if the query was successful
    if ($res) {
        echo "<script>alert('Thanks for your feedback!'); window.location.href = 'index.php';</script>";
        header("Location:feedback.php");
    } else {
        echo "alert('Feedback Not Inserted Successfully')";
    }
}elseif (isset($_POST['update'])) {
        
    
        $res = $obj->update();
        if ($res) {
            header("location:feedback.php");
        } else {
            echo "alert('Feedback Not Updated Successfully')";
        }
    }
    
    elseif (isset($_POST['delete'])) {
        $user_id=$_POST['user_id'];
        $res = $obj->delete($user_id);
        if ($res) {
            header("location:feedback.php");
        } else {
            echo "alert('feedback Not Deleted Successfully')";
        }
    }
?>