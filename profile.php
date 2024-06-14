<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header("Location: signin.php");
    exit();
}

include_once("config.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userId = $_SESSION['id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $userId");

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

$user = mysqli_fetch_assoc($result);
$username = $user['username'];
$robohashUrl = "https://robohash.org/" . $username . ".png?size=200x200";

$pickupResult = mysqli_query($conn, "SELECT * FROM pickup WHERE login_id = $userId");
$pickupRequests = mysqli_fetch_all($pickupResult, MYSQLI_ASSOC);
$pickupRequestMade = !empty($pickupRequests);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Online Raddiwala - Sell your scrap easily online.">
    <meta name="keywords" content="Raddiwala, Scrap, Online Scrap Selling">
    <meta name="author" content="Online Raddiwala">
    <title>User Profile</title>
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
                        <a class="nav-link text-black mr-2" href="#request-card" style="font-size: 18px;">Request</a>
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

    <!-- Main Content -->
    <section id="profile" class="main-container">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="content">
                        <h1 class="home-title">Manage Your <span style="color: #4fb355;">Profile,</span></br> Shape Your <span style="color: #4fb355;">Experience.</span></h1>
                        <form action="pickup-request.php" method="get">
                            <p class="home-tagline">Edit, Update, and Personalize</p>
                            <button type="submit" class="btn btn-success mt-0 mb-3">
                                <i class="fa fa-plus mr-2"></i> Request Pickup
                            </button>
                        </form>
                        <div class="col-md-auto">
                            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="request-card" style="margin-bottom: 30px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <?php if ($pickupRequestMade) : ?>
                        <?php foreach ($pickupRequests as $row) : ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h3 class="card-title">Your Pickup Request Details</h3>
                                    <ul class="list-unstyled">
                                        <li><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></li>
                                        <li><strong>Mobile:</strong> <?php echo htmlspecialchars($row['phone']); ?></li>
                                        <li><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></li>
                                        <li><strong>Area:</strong> <?php echo htmlspecialchars($row['area']); ?></li>
                                        <li><strong>City:</strong> <?php echo htmlspecialchars($row['city']); ?></li>
                                        <li><strong>Pincode:</strong> <?php echo htmlspecialchars($row['pincode']); ?></li>
                                        <li><strong>Scrap:</strong> <?php echo htmlspecialchars($row['scrap']); ?></li>
                                        <li><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></li>
                                        <li><strong>Time:</strong> <?php echo htmlspecialchars($row['time']); ?></li>
                                    </ul>
                                    <div class="text-center">
                                        <a href="edit-pickup-request.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Edit</a>
                                        <a href="delete-pickup-request.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">No Pickup Requests Found</h3>
                                <p class="card-text">You can manage your pickup request below:</p>
                                <form action="pickup-request.php" method="get">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-plus mr-2"></i> Request Pickup
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
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