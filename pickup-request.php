<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: signin.php");
    exit();
}

// Include database configuration
include_once("config.php");

// Check if the database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $scrap = $_POST['scrap'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $loginId = $_SESSION['id'];

    // Prepare the SQL statement using a prepared statement
    $sql = "INSERT INTO `pickup`(`name`, `phone`, `address`, `area`, `city`, `pincode`, `scrap`, `date`, `time`, `login_id`) VALUES 
	('$name','$phone','$address','$area',' $city',' $pincode',' $scrap','$date','$time','$loginId')";

    // Prepare the statement
    $result = mysqli_query($conn, $sql);

    // Check if the statement was prepared successfully
    if ($result) {
        echo "<script type='text/javascript'>alert('Your request has been submitted successfully. Thank you!'); window.location.href = 'profile.php'; </script>";
    } else {
        $errorMsg = 'Error: ' . mysqli_error($conn);
        echo "<script type='text/javascript'>alert('Something went wrong. $errorMsg'); window.location.href = 'pickup-service.php'; </script>";
    }

    mysqli_close($conn);
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
    <title>Pickup Service</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include font-awesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="background-color: #f8f9fa;">
    <nav class="navbar navbar-expand-lg navbar-light" style="margin-top: 20px;">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="home.php"  style="font-size: 24px; color: black;">
                Online<span style="color: #4fb355;">Raddiwala</span>
                <hr class="mx-1 my-1" style="width: 130px; height: 3px; background: linear-gradient(to right, #4fb355,#f8f9fa);">
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto font-weight-bold">
                    <li class="nav-item">
                        <a class="nav-link text-black mr-2" href="profile.php" style="font-size: 18px;">Profile</a>
                    </li>
                </ul>
            </div>

            <a href="logout.php" class="btn btn-danger d-lg-inline-block" style="font-size: 18px;">
                <i class="fa fa-sign-out"></i> Logout
            </a>

        </div>
    </nav>

    <div class="container mt-3 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="  border: none; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                    <div class="card-header" style=" background-color: #4fb355;color: #fff; font-weight: bold;">
                        Request Pickup Service
                    </div>
                    <div class="card-body">
                        <form action="pickup-request.php" method="POST">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label for="area">Area</label>
                                <input type="text" class="form-control" id="area" name="area" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" required>
                            </div>
                            <div class="form-group">
                                <label for="scrap">Type of Scrap</label>
                                <select class="form-control" id="scrap" name="scrap" required>
                                    <option value="Newspaper">Newspaper</option>
                                    <option value="Books">Books</option>
                                    <option value="Carton">Carton</option>
                                    <option value="Magazines">Magazines</option>
                                    <option value="White Papers">White Papers</option>
                                    <option value="Grey Board">Grey Board</option>
                                    <option value="Record paper">Record paper</option>
                                    <option value="Plain paper">Plain paper</option>
                                    <option value="Rough paper">Rough paper</option>
                                    <option value="Copy">Copy</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date">Preferred Pickup Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="time">Preferred Pickup Time</label>
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>