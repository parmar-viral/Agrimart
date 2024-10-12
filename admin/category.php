<?php
include 'error.php';
session_start();

if (!isset($_SESSION['ID'])) {
    include 'logout.php';
    exit();
}
 // Check for a success message in session
 $msg = null;
 if (isset($_SESSION['msg'])) {
     $msg = $_SESSION['msg'];
     unset($_SESSION['msg']); // Clear the message from the session after it's been displayed
     echo $msg;
 }
if ($_SESSION['ROLE'] == 0) {
    include_once('controller/category_controller.php');
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrimart - Admin Panel</title>
    <?php include 'css.php'; ?>
</head>

<body>
    <div class="page-wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="content">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <?php if ($msg) { ?>
                        <div class="alert alert-info text-center">
                            <?php echo $msg; ?>
                        </div>
                        <?php } ?>
                        <!-- Add Category Section -->
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">Add Category</h2>
                            <div class="glass-form">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text mb-2">
                                            <h6 class="mb-0">Category</h6>
                                        </span>
                                        <input type="text" name="category_name" class="form-control col-8"
                                            placeholder="Product Category" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text mb-2">
                                            <h6 class="mb-0">Image</h6>
                                        </span>
                                        <input type="file" name="category_image" class="form-control col-8"
                                            placeholder="Category Image" required>
                                        <button type="submit" name="submit" class="btn col-2">Submit</button>
                                    </div>
                                    <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>{$error_message}</div>";
                            }
                            ?>
                                </form>
                            </div>
                        </div>

                        <!-- Display Categories -->
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">Categories</h2>
                            <div class="table-responsive glass-table">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Category Name</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                $data = $categoryController->viewCategories();
                                while ($row = mysqli_fetch_assoc($data)) {
                                    echo "<tr>
                                        <th scope='row'>{$row['category_id']}</th>
                                        <td>" . htmlspecialchars($row['category_name']) . "</td>
                                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                                        <td>
                                        <form action='#' method='POST'>
                                        <input type='hidden' value='{$row['category_id']}' name='category_id'>
                                        <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updateCategoryModal' onclick='editCategory({$row['category_id']}, \"{$row['category_name']}\", \"{$row['category_image']}\")'><i class='bi bi-pencil-square'></i></button>
                                        <button class='btn btn-danger btn-sm' type='submit' name='delete' onclick='return confirm(\"Are you sure to delete?\")'><i class='bi bi-trash3'></i></button>
                                    </form>
                                        </td>
                                      </tr>";
                                }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Update Category Modal  -->
    <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content glass-card">
                <div class="modal-header">
                    <h5 class="modal-title text-light" id="updateCategoryModalLabel">Update Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="update_category_id" name="category_id">
                        <div class="mb-3">
                            <label for="update_category_name" class="form-label text-light">Category Name</label>
                            <input type="text" class="form-control" id="update_category_name" name="category_name"
                                required>
                        </div>
                        <!-- Image Section -->
                        <div class="mb-3">
                            <label for="category_image" class="form-label text-light">Category Image</label>
                            <img id="current_image" src="" alt="Category Image" class="img-thumbnail mb-2">
                            <input type="file" class="form-control" id="category_image" name="category_image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'js.php'; ?>
    <script>
    // Function to populate modal with category data
    function editCategory(id, name, image) {
        document.getElementById('update_category_id').value = id;
        document.getElementById('update_category_name').value = name;

        const imagePreview = document.getElementById('current_image');
        if (image) {
            imagePreview.src = image; // Display the category image
            imagePreview.style.display = 'block';
        } else {
            imagePreview.style.display = 'none';
        }
    }
    </script>

</body>

</html>
<?php } else {
    include 'logout.php';
}
?>