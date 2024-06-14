<?php
session_start();
include("config.php");

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if (isset($_POST['submit'])) {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        if ($password == "" || $confirm_password == "") {
            echo "Password field is empty.";
            echo "<br/>";
            echo "<a href='reset.php?token=$token'>Go back</a>";
        } elseif ($password != $confirm_password) {
            echo "<script>alert('Passwords do not match');window.location.href = 'reset.php?token=$token'; </script>";
        } else {
            $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $email = $row['email'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $stmt->bind_param("ss", $hashed_password, $email);
                $stmt->execute();

                $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                $stmt->bind_param("s", $token);
                $stmt->execute();

                echo "<script>alert('Password has been reset successfully. Please login.');window.location.href = 'signin.php'; </script>";
            } else {
                echo "<script>alert('Invalid token');window.location.href = 'forgot.php'; </script>";
            }
        }
    }
} else {
    echo "<script>alert('No token provided');window.location.href = 'forgot.php'; </script>";
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
    <title>Reset Password</title>
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
        </div>
    </nav>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="text-center">Reset Password</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="reset.php?token=<?php echo $token; ?>">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  required>
                            </div>
                            <input type="submit" value="Reset Password" name="submit" class="btn btn-success btn-block" />
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
