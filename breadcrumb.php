<?php
// breadcrumb.php
function generateBreadcrumb() {
    // Get the current script name
    $currentFile = basename($_SERVER['PHP_SELF']);
    
    // Define the breadcrumb structure
    $breadcrumb = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
    
    // Add "Home" to breadcrumb
    $breadcrumb .= '<li class="breadcrumb-item"><a href="index.php"><i class="bi bi-house-door-fill"></i>Home</a></li>';
    
    // Add the current page
    switch ($currentFile) {
        case 'index.php':
            $breadcrumb .= '<li class="breadcrumb-item active text text-center" aria-current="page">Home</li>';
            break;
        case 'about_us.php':
            $breadcrumb .= '<li class="breadcrumb-item active" aria-current="page">About Us</li>';
            break;
        case 'contact_us.php':
            $breadcrumb .= '<li class="breadcrumb-item active" aria-current="page">Contact Us</li>';
            break;
        case 'product.php':
            $breadcrumb .= '<li class="breadcrumb-item"><a href="products.php">Products</a></li>';
            if (isset($_GET['category'])) {
                $category = htmlspecialchars($_GET['category']);
                $breadcrumb .= '<li class="breadcrumb-item active" aria-current="page">' . $category . '</li>';
            }
            break;
        case 'feedback.php':
            $breadcrumb .= '<li class="breadcrumb-item active" aria-current="page">Feedback</li>';
            break;
        // Add more cases as needed for other pages
        default:
            $breadcrumb .= '<li class="breadcrumb-item active" aria-current="page">Unknown Page</li>';
            break;
    }
    
    $breadcrumb .= '</ol></nav>';
    
    return $breadcrumb;
}
?>
