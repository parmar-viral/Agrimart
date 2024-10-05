<?php 
include 'error.php';
session_start();
// Include database connection file
include_once('controller/database/db.php');
if (!isset($_SESSION['ID'])) {
    include 'logout.php';
    exit();
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
                        <div class="glass-card">
                            <h2 class="text-center text-light mb-3">feedback Data</h2>
                            <div class="table-responsive glass-table mb-3">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">message</th>

                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                $data = $obj->viewfeedback();
                                while ($row = mysqli_fetch_assoc($data)) {
                                    echo "<tr>
                                            <th scope='row'>{$row['user_id']}</th>
                                            <td>{$row['name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['message']}</td>
                                            <td>
                                                <form action='#' method='POST'>
                                                    <input type='number' value='{$row['user_id']}' name='user_id' hidden>
                                                    <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#updatedata'><i class='bi bi-pencil-square'></i></button>
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
    <?php include 'js.php'; ?>
</body>

</html>
<?php }else{            
            include 'logout.php';
        }        
?>