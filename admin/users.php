<?php
include 'error.php';
session_start();

// Check user session
if (!isset($_SESSION['ID'])) {
    include 'logout.php';
    exit();
}
// Check for a success message in session
$msg = null;
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    echo $msg;
    unset($_SESSION['msg']); // Clear the message from the session after it's been displayed
}
if (0 == $_SESSION['ROLE']) {
include_once('controller/user_controller.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <?php include 'css.php'; ?>
    <script src="asset/js/users.js" defer></script>
</head>

<body>
    <div class="page-wrapper">
        <?php include 'sidebar.php'; ?>
        <!-- Main Content -->
        <div class="content">
            <div class="container mt-5">
                <!-- Add Users Section with Glass Effect -->
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8">
                        <?php if ($msg) { ?>
                        <div class="alert alert-info text-center">
                            <?php echo $msg; ?>
                        </div>
                        <?php } ?>
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">Add Users</h2>
                            <div class="glass-form">
                                <form action="" method="POST">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text m-1 p-2"><i
                                                class="bi bi-person-circle"></i></span>
                                        <input type="text" name="fname" id="fname" class="m-1 p-2 form-control"
                                            placeholder="First Name" required>
                                        <span id="fnameError" class="error"></span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text m-1 p-2"><i
                                                class="bi bi-person-circle"></i></span>
                                        <input type="text" name="lname" id="lname" class="m-1 p-2 form-control"
                                            placeholder="Last Name" required>
                                        <span id="lnameError" class="error"></span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text m-1 p-2"><i class="bi bi-envelope-at"></i></span>
                                        <input type="email" name="email" id="email" class="m-1 p-2 form-control"
                                            placeholder="Email" required>
                                        <span id="emailError" class="error"></span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text m-1 p-2"><i
                                                class="bi bi-person-circle"></i></span>
                                        <input type="text" name="username" id="username" class="m-1 p-2 form-control"
                                            placeholder="Username" required>
                                        <span id="usernameError" class="error"></span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text m-1 p-2"><i class="bi bi-shield-lock"></i></span>
                                        <input type="password" name="password" id="password"
                                            class="m-1 p-2 form-control" placeholder="Password" required minlength="6">
                                        <span id="passwordError" class="error"></span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text m-1 p-2" id="confirmpassword"><i
                                                class="bi bi-shield-lock"></i></span>
                                        <input type="password" name="confirmpassword" id="confirmpassword"
                                            class="m-1 p-2 form-control" placeholder="Confirm Password" required>
                                        <span id="confirmpasswordError"></span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text m-1 p-2"><i
                                                class="bi bi-telephone-fill"></i></span>
                                        <input type="tel" name="mobile" id="mobile" class="m-1 p-2 form-control"
                                            placeholder="Mobile No" required>
                                        <span id="mobileError" class="error"></span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text m-1 p-2"><i class="bi bi-house"></i></span>
                                        <textarea name="address" id="address" class="form-control m-1 p-2"
                                            placeholder="Address" required></textarea>
                                    </div>
                                    <input type="hidden" name="role" value="2">
                                    <div class="text-center">
                                        <button type="submit" name="add_user" class="btn btn-success col-4">Add
                                            User</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Data -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">Users Data</h2>
                            <div class="table-responsive glass-table mb-3">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Mobile No.</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $data = $obj->view();
                                            while ($row = mysqli_fetch_assoc($data)) {
                                                echo "<tr>
                                                    <th scope='row'>{$row['id']}</th>                                                    
                                                    <td>{$row['fname']}</td>
                                                    <td>{$row['lname']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td>{$row['username']}</td>
                                                    <td>{$row['mobile']}</td>
                                                    <td>{$row['address']}</td>
                                                    <td>
                                                        <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updatedata' onclick='setUserData(" . json_encode($row) . ")'>
                                                            <i class='bi bi-pencil-square'></i>
                                                        </button>
                                                        <form method='POST' style='display:inline;'>
                                                            <input type='hidden' name='user_id' value='{$row['id']}'>
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

            <!-- Modal for updating user details -->
            <div class="modal fade" id="updatedata" tabindex="-1" aria-labelledby="updateUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content glass-card">
                        <div class="modal-header">
                            <h5 class="modal-title text-light" id="updateUserLabel">Update User Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="updateUserForm" method="POST">
                            <div class="modal-body">
                                <input type="hidden" id="user_id" name="user_id">
                                <div class="mb-3">
                                    <label for="modal_fname" class="form-label text-light">First Name</label>
                                    <input type="text" class="form-control" id="modal_fname" name="fname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_lname" class="form-label text-light">Last Name</label>
                                    <input type="text" class="form-control" id="modal_lname" name="lname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_email" class="form-label text-light">Email</label>
                                    <input type="email" class="form-control" id="modal_email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_username" class="form-label text-light">Username</label>
                                    <input type="text" class="form-control" id="modal_username" name="username"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_mobile" class="form-label text-light">Mobile No.</label>
                                    <input type="text" class="form-control" id="modal_mobile" name="mobile" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_address" class="form-label text-light">Address</label>
                                    <input type="text" class="form-control" id="modal_address" name="address" required>
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
        </div> <!-- End of Content -->
    </div> <!-- End of Wrapper -->

    <script>
    // Populate the modal with user data
    function setUserData(user) {
        document.getElementById('user_id').value = user.id;

        document.getElementById('modal_fname').value = user.fname;
        document.getElementById('modal_lname').value = user.lname;
        document.getElementById('modal_email').value = user.email;
        document.getElementById('modal_username').value = user.username;
        document.getElementById('modal_mobile').value = user.mobile;
        document.getElementById('modal_address').value = user.address;
    }
    </script>
    <?php include 'js.php'; ?>
</body>

</html>

<?php
} else {
    include 'logout.php';
}
?>