<?php

// Ensure 'ROLE' is set in the session before accessing it
if (isset($_SESSION['ROLE'])) {
    $role = $_SESSION['ROLE'];
} else {
    $role = null; // Or set a default value, or handle the case when the role is not set
}

// Include necessary files and handle database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "Agro";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch categories
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
       <?php include 'css.php'; ?>
</head>

<body>
    <footer class="footer">
        <div class="quick-links">
            <h5>Quick Links</h5>
            <a href="index.php">Home</a>
            <a href="about_us.php">About Us</a>
            <a href="contact_us.php">Contact</a>
            <a href="faq.php">FAQ</a>
        </div>

        <div class="categories">
            <h5>Categories</h5>
            <?php
            if ($result->num_rows > 0) {
                echo '<ul class="category-item">';
                while ($row = $result->fetch_assoc()) {
                    echo '<li><a class="nav-link" href="product.php?category=' . $row['category_name'] . '">' . $row['category_name'] . '</a></li>';
                }
                echo '</ul>';
            } else {
                echo "No categories found.";
            }
            $conn->close();
            ?>
        </div>

        <div class="services">
            <h5>Our Services</h5>
            <a href="#">Delivery</a>
            <a href="#">Customer Support</a>
            <a href="#">Wholesale</a>
            <a href="#">Consulting</a>
        </div>

        <div class="contact-us">
            <h5>Contact Us</h5>
            <div class="contact text text-light">
            <p>Address: 123 Farm Road, Agro City, 456789</p>
            <p>Email: support@agrimart.com</p>
            <p>Phone: +1 (123) 456-7890</p>
            <p>Working Hours: Mon-Fri, 9 AM - 6 PM</p>
            </div>

          
        </div>

        <div class="social-media">
            <h5>Follow Us</h5>
            <div class="social-media-icons">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </footer>
</body>

</html>






