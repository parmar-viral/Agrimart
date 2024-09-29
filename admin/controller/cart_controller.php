<?php 
class products
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
                
            $sql = "SELECT * FROM `products`";
            $res = mysqli_query($this->db,$sql);
            return $res;
        }
    }
    $obj = new products();
    if (isset($_POST['submit'])) {
        $product_name=$_POST['product_name'];
        $product_description=$_POST['product_description'];
        $product_price=$_POST['product_price'];

        $file=$_FILES['product_image']['name'];
	    $tname=$_FILES['product_image']['tmp_name'];

        $folder="./asset/image/".$file;
	    move_uploaded_file($tname,$folder);

        $product_category=$_POST['product_category'];
        $result=$obj->insert($product_name,$product_description,$product_price,$folder,$product_category);
        
        if ($result==true) {
          header("Location:product.php");
          die();
        }else{
          $errorMsg  = "You are not Registred..Please Try again";
          echo $errorMsg;
        }   
    }/*
    if (isset($_POST['update'])) {
        $id = $_POST['course_id'];
        $course = $_POST['course'];
    
        $res = $obj->update($id, $course);
        if ($res) {
            header("location:courses.php");
        } else {
            echo "alert('data not updated successfully')";
        }
    } 
    else*/if (isset($_POST['delete'])) {
        $product_id=$_POST['product_id'];
        $res = $obj->delete($product_id);
        if ($res) {
            header("location:product.php");
        } else {
            echo "not deleted";
        }
    }
?>