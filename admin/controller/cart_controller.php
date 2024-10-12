<?php 
class cart
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
        function delete($product_id)
        {
            $sql = "DELETE FROM `cart_items` WHERE `product_id`='$product_id'";
            $res = mysqli_query($this->db, $sql);
            return $res;
        }
        function view($user_id)
        {
               $sql = "SELECT * FROM cart_items WHERE `user_id` = '$user_id'";
            $res = mysqli_query($this->db, $sql);
            return $res;
        }
    }
    $obj = new cart();
    if (isset($_POST['submit'])) {
       
        $result=$obj->insert();
        
        if ($result==true) {
          header("Location:cart.php");
        }else{
          
        }   
    }
    elseif (isset($_POST['delete'])) {
        $product_id=$_POST['item_id'];
        $res = $obj->delete($product_id);
        if ($res) {
            $_SESSION['msg'] = "product deleted from cart deleted successfully.";
            header("location:cart.php");
            exit();
        } else {
            $_SESSION['msg'] = "Failed to delete product.";
        }
    }
?>