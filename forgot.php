<?php
session_start();
include("config.php");

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    if ($email == "") {
        echo "Email field is empty.";
        echo "<br/>";
        echo "<a href='forgot.php'>Go back</a>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $token = bin2hex(random_bytes(50));
            $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $token);
            $stmt->execute();

            $resetLink = "http://localhost/OnlineRaddiwala/reset.php?token=" . $token;
            mail($email, "Password Reset", "Click here to reset your password: " . $resetLink, "From: anywheretraveles25@gmail.com");

            echo "<script>alert('Password reset link has been sent to your email.');window.location.href = 'signin.php'; </script>";
        } else {
            echo "<script>alert('Email not found');window.location.href = 'forgot.php'; </script>";
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="margin-top: 20px;">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="index.php"  style="font-size: 24px; color: black;">
                Online<span style="color: #4fb355;">Raddiwala</span>
                <hr class="mx-1 my-1" style="width: 130px; height: 3px; background: linear-gradient(to right, #4fb355,#f8f9fa);">
            </a>
        </div>
    </nav>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="text-center">Forgot Password</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="forgot.php">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <input type="submit" value="Send Reset Link" name="submit" class="btn btn-success btn-block" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
