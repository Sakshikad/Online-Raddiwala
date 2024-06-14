<?php
session_start();
if (isset($_SESSION['valid'])) {
    include_once("config.php");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $userId = $_SESSION['id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $userId");

    if ($result) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Online Raddiwala - Sell your scrap easily online.">
    <meta name="keywords" content="Raddiwala, Scrap, Online Scrap Selling">
    <meta name="author" content="Online Raddiwala">
    <title>Home</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include font-awesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light" style="margin-top: 20px;">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="home.php" style="font-size: 24px; color: black;">
                Online<span style="color: #4fb355;">Raddiwala</span>
                <hr class="mx-1 my-1" style="width: 130px; height: 3px; background: linear-gradient(to right, #4fb355,#f8f9fa);">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto font-weight-bold">
                    <li class="nav-item">
                        <a class="nav-link text-black mr-2" href="profile.php" style="font-size: 18px;">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black mr-2" href="#" id="feedback" style="font-size: 18px;">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black mr-2" href="#contact" style="font-size: 18px;">Contact Us</a>
                    </li>
                </ul>
            </div>

            <a href="logout.php" class="btn btn-danger d-lg-inline-block" style="font-size: 18px;">
                <i class="fa fa-sign-out"></i> Logout
            </a>

        </div>
    </nav>

    <?php include 'includes/feedback.php'; ?>


    <section id="home" class="main-container">
        <div class="container ">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="content">
                        <h2 class="home-title">Welcome <span style="color: #4fb355;"><?php echo $user['username']; ?></span> to <br />Online Raddiwala!</h2>
                        <p class="home-tagline">Back and ready to make an impact! Let's get started</p>
                        <form>
                            <a href="pickup-request.php" class="btn btn-success">
                                <i class="fa fa-plus mr-2"></i> Request Pickup
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>

</html>