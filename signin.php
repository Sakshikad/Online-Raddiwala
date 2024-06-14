<?php
session_start();

include("config.php");

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if ($email == "" || $password == "") {
        echo "Either email or password field is empty.";
        echo "<br/>";
        echo "<a href='signin.php'>Go back</a>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['valid'] = true;
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                header("Location: home.php");
                exit();
            } else {
                echo "<script>alert('Invalid password');window.location.href = 'signin.php'; </script>";
            }
        } else {
            echo "<script>alert('User not found');window.location.href = 'signin.php'; </script>";
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
    <title>Login</title>
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
            <a class="navbar-brand font-weight-bold" href="index.php"  style="font-size: 24px; color: black;">
                Online<span style="color: #4fb355;">Raddiwala</span>
                <hr class="mx-1 my-1" style="width: 130px; height: 3px; background: linear-gradient(to right, #4fb355,#f8f9fa);">
            </a>
            <a href="signup.php" class="btn btn-success d-lg-inline-block mr-2" style="font-size: 18px;">
                <i class="fa fa-user-plus"></i> Sign Up
            </a>
        </div>
    </nav>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="signin.php">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <input type="submit" value="Login" name="submit" class="btn btn-success btn-block" />
                        </form>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="row">
                            <div class="col">
                                Don't have an account? <a href="signup.php">Sign Up here</a>
                            </div>
                            <div class="col text-right">
                                <a href="forgot.php">Forgot Password?</a>
                            </div>
                        </div>
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
