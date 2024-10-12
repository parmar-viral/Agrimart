<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    function insert($product_name, $product_description, $product_price, $product_image, $product_category)
    {
        $sql = "INSERT INTO products (product_name, description, product_price, product_image, category, created_at) 
                VALUES ('$product_name', '$product_description', '$product_price', '$product_image', '$product_category', now())";
                $res=mysqli_query($this->db,$sql);
                return $res;
    }
    function update($product_id, $product_name, $product_description, $product_price, $product_image, $product_category)
{
    $sql = "UPDATE products 
            SET product_name='$product_name', description='$product_description', product_price='$product_price', 
                product_image='$product_image', category='$product_category', updated_at=now() 
            WHERE product_id='$product_id'";
    $res = mysqli_query($this->db, $sql);
    return $res;
}

    function view()
    {
        $sql = "SELECT * FROM products";
        $res=mysqli_query($this->db,$sql);
        return $res;
    }
    function delete($product_id)
    {
        $sql = "DELETE FROM products WHERE `product_id`='$product_id'";
        $res=mysqli_query($this->db,$sql);
        return $res;
    }
}

$obj = new products();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_description'];
            $product_price = $_POST['product_price'];
            $product_category = $_POST['product_category'];

            $file = $_FILES['product_image']['name'];
            $tname = $_FILES['product_image']['tmp_name'];
            $folder = "../admin/asset/image/" . basename($file);

        
            if (move_uploaded_file($tname, $folder)) {
                $res = $obj->insert($product_name, $product_description, $product_price, $folder, $product_category);
                if ($res) {
                    $_SESSION['msg'] = "Product added successfully.";
                    header("Location: products.php");
                    exit();
                } else {
                    $_SESSION['msg'] = "Failed to add product.";
                }
            } else {
                $_SESSION['msg'] = "Failed to upload image.";
            }
        }


        if (isset($_POST['update'])) {
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_description'];
            $product_price = $_POST['product_price'];
            $product_category = $_POST['product_category'];
        
            $file = $_FILES['product_image']['name'];
            $tname = $_FILES['product_image']['tmp_name'];
            $folder = "../admin/asset/image/" . basename($file);
        
            if (!empty($file)) {
                // Image is updated, move the uploaded file
                if (move_uploaded_file($tname, $folder)) {
                    $product_image = $folder;
                } else {
                    $_SESSION['msg'] = "Failed to upload image.";
                    header("Location: products.php");
                    exit();
                }
            } else {
                // If no new image is uploaded, retain the old image
                $product_image_query = "SELECT product_image FROM products WHERE product_id='$product_id'";
                $result = mysqli_query($obj->db, $product_image_query);
                $row = mysqli_fetch_assoc($result);
                $product_image = $row['product_image'];
            }
        
            // Now perform the update
            $res = $obj->update($product_id, $product_name, $product_description, $product_price, $product_image, $product_category);
            if ($res) {
                $_SESSION['msg'] = "Product updated successfully.";
                header("Location: products.php");
                exit();
            } else {
                $_SESSION['msg'] = "Failed to update product.";
            }
        }
        
        if (isset($_POST['delete'])) {
            $product_id = $_POST['product_id'];
            $res = $obj->delete($product_id);
            if ($res) {
                $_SESSION['msg'] = "Product deleted successfully.";
                header("Location: products.php");
                exit();
            } else {
                $_SESSION['msg'] = "Failed to delete product.";
            }
        }
}
?>