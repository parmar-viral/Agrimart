<?php 
class order
    {
        public $db;  // Declare the property

        function __construct(){        
            $conn=mysqli_connect('localhost','root','','Agro');
            $this->db=$conn; //Initialize the property
            if(mysqli_connect_error()){
                echo 'failed to connect'.mysqli_connect_error();
            }
        }
        function insert()
        {
            $sql  = "";       
            $res=mysqli_query($this->db,$sql);
            return $res;
        }
    
        function update($order_id,$quantity,$total_price)
        {
            
            // Update the order in the database
            $sql = "UPDATE orders SET `quantity` = '$quantity', `total_price` ='$total_price' WHERE `id` = '$order_id'";
            $res=mysqli_query($this->db,$sql);
            return $res;
        }
        function delete($order_id)
        {
            $sql="DELETE FROM orders WHERE `id`='$order_id'";
            $res=mysqli_query($this->db,$sql);
            return $res;
        }
        function view()
        {
                        
            // Fetch all orders with product names and prices
            $sql = "SELECT orders.id, orders.user_id, users.username, products.product_name, products.product_price, orders.quantity, orders.total_price, orders.order_date 
            FROM orders 
            JOIN users ON orders.user_id = users.id 
            JOIN products ON orders.product_id = products.product_id"; // Fixed the SQL syntax here

            $res = mysqli_query($this->db, $sql);
            return $res;
        }
    }
    $obj = new order();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        
        $res=$obj->insert();
        
        if ($res==true) {
            $_SESSION['msg']="";
          header("Location:orders.php");
          die();
        }else{
            $_SESSION['msg']="";
        }   
    }elseif (isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    $result=$obj->update($order_id,$quantity,$total_price);
    if ($res) {
        $_SESSION['msg']="orders updated successfully";
    }else{
         $_SESSION['msg']="failed to update order";
    }    
    // Redirect or show a success message
    header('Location: orders.php'); // Redirect back to the orders page
    exit();

}elseif(isset($_POST['delete'])){
    $order_id=$_POST['order_id'];
    $res=$obj->delete($order_id);  
    if ($res) {
        $_SESSION['msg']="orders deleted successfully";
    }else{
        $_SESSION['msg']="failed to delete order";
    }
    header('Location: orders.php');
    exit();
}
    }
?>