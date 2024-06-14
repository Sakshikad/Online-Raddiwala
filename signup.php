<?php
session_start();
include("config.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('Please fill in all fields.');window.location.href = 'signup.php'; </script>";
        exit();
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');window.location.href = 'signup.php'; </script>";
        exit();
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Email is already registered. Please use a different email.');window.location.href = 'signup.php'; </script>";
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Registration Successful. Please login.');window.location.href = 'signin.php'; </script>";
                exit();
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
    }
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
    <title>Sign Up</title>
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
            <a class="navbar-brand font-weight-bold" href="index.php" style="font-size: 24px; color: black;">
                Online<span style="color: #4fb355;">Raddiwala</span>
                <hr class="mx-1 my-1" style="width: 130px; height: 3px; background: linear-gradient(to right, #4fb355,#f8f9fa);">
            </a> 
            <a href="signin.php" class="btn btn-success d-lg-inline-block" style="font-size: 18px;">
                <i class="fa fa-sign-in"></i> Login
            </a>
        </div>
    </nav>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="text-center">Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="signup.php">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  required>
                            </div>
                            <input type="submit" value="Sign Up" name="submit" class="btn btn-success btn-block" />
                        </form>
                    </div>
                    <div class="card-footer text-muted">
                        Already have an account? <a href="signin.php">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
