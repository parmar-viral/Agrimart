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
        
        function update($product_id,$product_name,$product_description,$product_price,$folder,$product_category)
        {
            $sql = "UPDATE products SET product_name='$product_name',description='$product_description', product_price='$product_price', product_image='$folder', category='$product_category' WHERE product_id='$product_id'";
            $res = mysqli_query($this->db, $sql);
            return $res;
        }
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

        $folder="../asset/image/".$file;
	    move_uploaded_file($tname,$folder);

        $product_category=$_POST['product_category'];
        $result=$obj->insert($product_name,$product_description,$product_price,$folder,$product_category);
        
        if ($result==true) {
          header("Location:products.php");
          die();
        }else{
          $errorMsg  = "You are not Registred..Please Try again";
          echo $errorMsg;
        }   
    }
    elseif (isset($_POST['update'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_description = $_POST['product_description'];
        $product_price = $_POST['product_price'];
        $product_category = $_POST['product_category'];
        
        // Check if a new file was uploaded
        if (!empty($_FILES['product_image']['name'])) {
            $file = $_FILES['product_image']['name'];
            $tname = $_FILES['product_image']['tmp_name'];
            $folder = "./asset/image/" . $file;
            move_uploaded_file($tname, $folder);
        } else {
            // Use the current image if no new image is uploaded
            $current_product = mysqli_fetch_assoc($obj->view());  // Fetch the current product
            $folder = $current_product['product_image'];
        }
    
        $res = $obj->update($product_id, $product_name, $product_description, $product_price, $folder, $product_category);
        if ($res) {
            header("location:products.php");
        } else {
            echo "alert('Data not updated successfully')";
        }
    }
    
    elseif (isset($_POST['delete'])) {
        $product_id=$_POST['product_id'];
        $res = $obj->delete($product_id);
        if ($res) {
            header("location:products.php");
        } else {
            echo "not deleted";
        }
    }
?>
