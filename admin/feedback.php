<?php 
include 'error.php';
session_start();

if (!isset($_SESSION['ID'])) {
    include 'logout.php';
    exit();
}
  // Check for a success or error message in session
  $msg = null;
  if (isset($_SESSION['msg'])) {
      $msg = $_SESSION['msg'];
      unset($_SESSION['msg']); // Clear the message from the session after it's been displayed
  }
if(0==$_SESSION['ROLE']){
    include 'controller/feedback_controller.php';
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
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
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">Feedback Data</h2>
                            <div class="table-responsive glass-table mb-3">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $data = $obj->view();
                                        while ($row = mysqli_fetch_assoc($data)) {
                                            echo "<tr>
                                                    <th scope='row'>{$row['user_id']}</th>
                                                    <td>{$row['name']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td>{$row['message']}</td>
                                                    <td>
                                                        <form action='#' method='POST'>
                                                        <input type='hidden' value='{$row['user_id']}' name='id'>
                                                        <button type='button' class='btn btn-warning btn-sm edit-btn' 
                                                                data-bs-toggle='modal' data-bs-target='#updateFeedbackModal'
                                                                data-id='{$row['user_id']}' 
                                                                data-name='{$row['name']}' 
                                                                data-email='{$row['email']}' 
                                                                data-message='{$row['message']}'>
                                                                <i class='bi bi-pencil-square'></i>
                                                        </button>
                                                        <button class='btn btn-danger btn-sm' type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this feedback?\")'>
                                                        <i class='bi bi-trash3'></i>
                                                    </button>
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
            <!-- Update Feedback Modal -->
            <div class="modal fade" id="updateFeedbackModal" tabindex="-1" aria-labelledby="updateFeedbackModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content glass-card">
                        <div class="modal-header">
                            <h5 class="modal-title text-light" id="updateFeedbackModalLabel">Update Feedback</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="feedback.php" method="POST">
                            <div class="modal-body">
                                <input type="hidden" id="update_user_id" name="user_id">

                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="update_name" class="form-label text-light">Name</label>
                                    <input type="text" class="form-control" id="update_name" name="name" required>
                                </div>

                                <!-- Email Field -->
                                <div class="mb-3">
                                    <label for="update_email" class="form-label text-light">Email</label>
                                    <input type="email" class="form-control" id="update_email" name="email" required>
                                </div>

                                <!-- Message Field -->
                                <div class="mb-3">
                                    <label for="update_message" class="form-label text-light">Message</label>
                                    <textarea class="form-control" id="update_message" name="message" rows="4"
                                        required></textarea>
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
            <!-- End Update Feedback Modal -->


        </div>
    </div>
    <?php include 'js.php'; ?>
    <script>
    // Populate the modal with existing feedback data
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const message = this.getAttribute('data-message');

            document.getElementById('update_user_id').value = userId;
            document.getElementById('update_name').value = name;
            document.getElementById('update_email').value = email;
            document.getElementById('update_message').value = message;
        });
    });
    </script>
</body>

</html>
<?php }else{            
            include 'logout.php';
        }        
?>