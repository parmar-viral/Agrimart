<?php
include 'error.php';
session_start();
// Include database connection file
include_once('controller/database/db.php');

// Check user session
if (!isset($_SESSION['ID'])) {
    include 'logout.php';
    exit();
}

// If user role is admin (assuming 0 is for users and 1 is for admin)
if (0 == $_SESSION['ROLE']) {
    include 'controller/product_controller.php';

    // Check for a success or error message in session
    $msg = null;
    if (isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']); // Clear the message from the session after it's been displayed
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrimart</title>
    <?php include 'css.php'; ?>
</head>

<body>
    <div class="page-wrapper">
        <!-- Wrapper for sidebar and content -->
        <?php include 'sidebar.php'; ?>
        <div class="content">
            <div class="container mt-5">

                <!-- Add Products Section with Glass Effect -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php if ($msg) { ?>
                        <!-- Display message after any action (insert, update, delete) -->
                        <div class="alert alert-info text-center">
                            <?php echo $msg; ?>
                        </div>
                        <?php } ?>
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">Add Products</h2>
                            <div class="glass-form">
                                <form class="mt-3" action="" method="POST" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text col-2" id="productname">
                                            <h6 class="mb-0">Product</h6>
                                        </span>
                                        <input type="text" name="product_name" class="form-control p-2"
                                            placeholder="Add New Product" required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text col-2" id="productdescription">
                                            <h6 class="mb-0">Description</h6>
                                        </span>
                                        <input type="text" name="product_description" class="form-control p-2"
                                            placeholder="Add Product Description" required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text col-2" id="productprice">
                                            <h6 class="mb-0">Price</h6>
                                        </span>
                                        <input type="number" name="product_price" class="form-control p-2"
                                            placeholder="Add Product Price" required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text col-2" id="productimage">
                                            <h6 class="mb-0">Image</h6>
                                        </span>
                                        <input type="file" name="product_image" class="form-control p-2" required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text col-2" id="productcategory">
                                            <h6 class="mb-0">Category</h6>
                                        </span>
                                        <input type="text" name="product_category" class="form-control p-2"
                                            placeholder="Add Product Category" required>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" name="submit"
                                            class="btn btn-success col-4">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Existing Products Section with Cards -->
                <div class="row mt-5">
                    <h3 class="text-center text-light mb-3">Existing Products</h3>
                </div>
                <div class="row">
                    <?php
                    $data = $obj->view();
                    while ($row = mysqli_fetch_assoc($data)) {
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                        <div class="glass-card p-3">
                            <img src="<?php echo htmlspecialchars($row['product_image']); ?>" class="card-img-top mb-3"
                                alt="Product Image" style="height: 220px; object-fit: cover; width: 100%; border-radius:5px">

                            <p class="text-light"><?php echo htmlspecialchars($row['product_name']); ?></p>
                            <p class="text-light">$<?php echo number_format($row['product_price'], 2); ?></p>
                            <p class="text-light"><?php echo htmlspecialchars($row['created_at']); ?></p>

                            <!-- Centered update and delete buttons -->
                            <div class="d-flex justify-content-center">
                                <form action="#" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

                                    <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                                        data-bs-target="#updateProductModal"
                                        onclick='setProductData(<?php echo json_encode($row); ?>)'>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button type="submit" class="btn btn-danger btn-sm" name="delete"
                                        onclick="return confirm('Are you sure you want to delete?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Modal for updating product details -->
        <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content glass-card">
                    <div class="modal-header">
                        <h5 class="modal-title text-light" id="updateProductModalLabel">Update Product Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateProductForm" action="" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" id="product_id" name="product_id">

                            <div class="mb-3">
                                <label for="product_name" class="form-label text-light">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="product_description" class="form-label text-light">Product
                                    Description</label>
                                <input type="text" class="form-control" id="product_description"
                                    name="product_description" required>
                            </div>
                            <div class="mb-3">
                                <label for="product_price" class="form-label text-light">Price</label>
                                <input type="number" class="form-control" id="product_price" name="product_price"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="product_category" class="form-label text-light">Category</label>
                                <input type="text" class="form-control" id="product_category" name="product_category"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="product_image" class="form-label text-light">Product Image</label>
                                <img id="current_image" src="" alt="Product Image" class="img-thumbnail mb-2">
                                <input type="file" class="form-control" id="product_image" name="product_image">
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
    </div>

    <?php include 'js.php'; ?>
    <script>
    // Function to populate modal with product data
    function setProductData(product) {
        document.getElementById('product_id').value = product.product_id;
        document.getElementById('product_name').value = product.product_name;
        document.getElementById('product_description').value = product.product_description;
        document.getElementById('product_price').value = product.product_price;
        document.getElementById('product_category').value = product.product_category;

        const imagePreview = document.getElementById('current_image');
        if (product.product_image) {
            imagePreview.src = product.product_image;
            imagePreview.style.display = 'block';
        } else {
            imagePreview.style.display = 'none';
        }
    }
    </script>
</body>

</html>

<?php
} else {
    include 'logout.php';
}
?>