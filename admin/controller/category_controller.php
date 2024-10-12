<?php
class CategoryController
{
    public $db;  // Declare the property

    function __construct()
    {
        $this->db = new mysqli('localhost', 'root', '', 'Agro');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    function addCategory($categoryName, $folder)
    {
        // Check if category already exists
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE category_name = ?");
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false; // Category already exists
        }

        // Insert new category
        $stmt = $this->db->prepare("INSERT INTO categories (category_name, category_image) VALUES (?, ?)");
        $stmt->bind_param("ss", $categoryName, $folder);
        return $stmt->execute();
    }

    function updateCategory($categoryId, $categoryName)
    {
        // Check if category name exists with a different ID
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE category_name = ? AND category_id != ?");
        $stmt->bind_param("si", $categoryName, $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false; // Category already exists
        }

        // Update category
        $stmt = $this->db->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
        $stmt->bind_param("si", $categoryName, $categoryId);
        return $stmt->execute();
    }

    function deleteCategory($categoryId)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE category_id = ?");
        $stmt->bind_param("i", $categoryId);
        return $stmt->execute();
    }

    function viewCategories()
    {
        $sql = "SELECT * FROM categories";
        $result = $this->db->query($sql);
        return $result;
    }
}

// Create an object of CategoryController and handle form submissions
$categoryController = new CategoryController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $categoryName = $categoryController->db->real_escape_string($_POST['category_name']);

        $file = $_FILES['category_image']['name'];
        $tname = $_FILES['category_image']['tmp_name'];
        $folder = "../admin/asset/image/category/" . basename($file);

        if (move_uploaded_file($tname, $folder)) {
            $res = $categoryController->addCategory($categoryName, $folder);
            if ($res) {
                $_SESSION['msg'] = "Category added successfully!";
                header("Location: category.php");
                exit();
            } else {
                $_SESSION['msg'] = "Category name already exists.";
            }
        } else {
            $_SESSION['msg'] = "Failed to upload image.";
        }
    } elseif (isset($_POST['update'])) {
        $categoryId = $_POST['category_id'];
        $categoryName = $categoryController->db->real_escape_string($_POST['category_name']);
        
        if ($categoryController->updateCategory($categoryId, $categoryName)) {
            $_SESSION['msg'] = "Category updated successfully!";
            header("Location: category.php");
            exit();
        } else {
            $error_message = "Category name already exists or error updating.";
        }
    } elseif (isset($_POST['delete'])) {
        $categoryId = $_POST['category_id'];
        if ($categoryController->deleteCategory($categoryId)) {
            $_SESSION['msg'] = "Category deleted successfully!";
            header("Location: category.php");
            exit();
        } else {
            $error_message = "Error deleting category.";
        }
    }
}
?>
