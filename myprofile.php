<?php
session_start();

// Simulate user data (replace with real data from your database)
$user = [
    'username' => $user['username'],
    'email' => $row['email'],
    'profile_picture' => 'images/admin_logo.jpg', // Default profile picture path
    'cart_items' => $row['products'] // Sample cart items
];

// Example handling of profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        $user['profile_picture'] = $target_file; // Update the profile picture path
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
   <?php include 'css.php'; ?>
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="profile-container item center">
        <h1>My Profile</h1>
        
        <!-- Profile Picture -->
        <div class="profile-picture">
            <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
            <form action="myprofile.php" method="post" enctype="multipart/form-data">
                <input type="file" name="profile_picture" accept="image/*">
                <button type="submit">Change Picture</button>
            </form>
        </div>
        
        <!-- Username and Email -->
        <div class="user-details">
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        </div>
        
        <!-- Change Password -->
        <div class="change-password">
            <h3>Change Password</h3>
            <form action="change_password.php" method="post">
                <input type="password" name="current_password" placeholder="Current Password" required>
                <input type="password" name="new_password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Change Password</button>
            </form>
        </div>
        
        <!-- Cart Items -->
        <div class="cart-items">
            <h3>Your Cart Items</h3>
            <ul>
                <?php foreach ($user['cart_items'] as $item): ?>
                    <li><?php echo $item; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        
    
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
    
   
</body>
</html>
