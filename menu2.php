<nav class="navbar container align-item-center nav-item  m-auto navbar-expand-lg mt-3 p-2 mb-3">
    <div class="container-fluid text-center">
        <div class="d-flex  justify-content-center  mt-3">
            <img class="img-logo" src="asset/css/images/logo.png">
        </div>
        <a class="navbar-brand " href="index.php"> Agrimart </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item toggle">
                    <a class="nav-link  " href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="about_us.php">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="contact_us.php"> Contact us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product.php"> Products</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="orders.php">My Orders</a> <!-- New Menu Item -->
            </li>
                <li class="nav-item ">
                    <a class="nav-link " href="feedback.php">Feedback</a>
                </li>
                <li class="nav-item toggle">
                    <a class="nav-link  " href="cart.php"><i class="bi bi-cart"></i></a>
                </li>
            </ul>
            <?php
            include 'admin/error.php';
            if (2 == $_SESSION['ROLE']) { ?>
                <form class="d-flex">
                

                    <a class="nav-link text-dark" href="logout.php">Hi, <?php echo ucwords($_SESSION['USERNAME']); ?>
                        <span class="btn text-danger"><i class="bi bi-person-circle"></i> Logout</span></a>
                </form>
            <?php } ?>
        </div>
    </div>
</nav>