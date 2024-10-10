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
        function insert($product_name,$product_description,$product_price,$folder,$product_category)
        {
            $sql  = "INSERT INTO `products` (`product_name`, `description`, `product_price`,`product_image`,`category`) VALUES ('$product_name','$product_description','$product_price','$folder','$product_category')";       
            $res=mysqli_query($this->db,$sql);
            return $res;
        }
        /*
        function update()
        {
            $sql = "UPDATE `products` SET `product`='$product' WHERE `product_id`='$'";
            $res = mysqli_query($this->db, $sql);
            return $res;
        }*/
        function delete($product_id)
        {
            $sql = "DELETE FROM `products` WHERE `product_id`='$product_id'";
            $res = mysqli_query($this->db, $sql);
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
    if (isset($_POST['submit'])) {
        
        $result=$obj->insert();
        
        if ($result==true) {
          header("Location:orders.php");
          die();
        }else{
          $errorMsg  = "You are not Registred..Please Try again";
          echo $errorMsg;
        }   
    }elseif (isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    // Update the order in the database
    $update_sql = "UPDATE orders SET `quantity` = '$quantity', `total_price` ='$total_price' WHERE `id` = '$order_id'";
    $res=mysqli_query($conn,$sql);
    if ($res) {
        echo "orders updated successfully";
    }else{
        echo "orders not updated";
    }    
    // Redirect or show a success message
    header('Location: orders.php'); // Redirect back to the orders page
    exit();

}elseif(isset($_POST['delete'])){
    $order_id=$_POST['order_id'];
    $sql="DELETE FROM orders WHERE `id`='$order_id'";
    $res=mysqli_query($conn,$sql);
    if ($res) {
        echo "orders deleted successfully";
    }else{
        echo "orders not deleted";
    }
    // Redirect or show a success message
    header('Location: orders.php'); // Redirect back to the orders page
    exit();
}
?>