<?php
class FeedbackController
{
    private $db;
    function __construct()
    {
        $conn = mysqli_connect('localhost', 'root', '', 'Agro');
        $this->db = $conn;  //Initialize the property
        if (mysqli_connect_error()) {
            echo 'failed to connect' . mysqli_connect_error();
        }
    }
    public function feedback($name,$email,$message)
    {
        $query = "SELECT name, email, message FROM feedback WHERE user_id = " . $_SESSION['ID'];
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query Failed: " . mysqli_error($this->db));
        }
        return $result;
    }
    public function viewfeedback()
    {
        $query = "SELECT * FROM feedback";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
}
$obj=new FeedbackController();
?>
