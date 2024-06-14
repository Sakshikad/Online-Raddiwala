<?php session_start(); ?>
<?php
if (!isset($_SESSION['valid'])) {
  header('Location: signin.php');
}
?>
<?php
require_once('config.php');


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM pickup WHERE id=" . $id;
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
  } else {
    $errorMsg = 'Could not Find Any Record';
  }
}

if (isset($_POST['update'])) {
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


  if (!isset($errorMsg)) {
    $sql = "UPDATE pickup SET name = '" . $name . "',phone = '" . $phone . "',address = '" . $address . "',area = '" . $area . "',city = '" . $city . "',pincode = '" . $pincode . "',scrap = '" . $scrap . "',date = '" . $date . "',time = '" . $time . "' where id=" . $id;
    $result = mysqli_query($conn, $sql);
    if ($result) {
      echo "<script type='text/javascript'>alert('Your request updated successfully,Thank you!!');window.location.href  = 'profile.php'; </script>";
    } else {
      $errorMsg = 'Error ' . mysqli_error($conn);
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
      <a class="navbar-brand font-weight-bold" href="home.php" style="font-size: 24px; color: black;">
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
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card" style="  border: none; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
          <div class="card-header" style=" background-color: #4fb355;color: #fff; font-weight: bold;">
            Request Pickup Service
          </div>
          <div class="card-body">
            <form method="POST" action="">
              <div class="form-group">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>">
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>">
                </div>
                <div class="form-group">
                  <label for="area">Area</label>
                  <input type="text" class="form-control" id="area" name="area" value="<?php echo $row['area']; ?>">
                </div>
                <div class="form-group">
                  <label for="city">City</label>
                  <input type="text" class="form-control" id="city" name="city" value="<?php echo $row['city']; ?>">
                </div>
                <div class="form-group">
                  <label for="pincode">Pincode</label>
                  <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo $row['pincode']; ?>">
                </div>
                <div class="form-group">
                  <label for="scrap">Type of Scrap</label>
                  <select class="form-control" id="scrap" name="scrap" value="<?php echo $row['scrap']; ?>">
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
                  <input type="date" class="form-control" id="date" name="date" value="<?php echo $row['date']; ?>">
                </div>
                <div class="form-group">
                  <label for="time">Preferred Pickup Time</label>
                  <input type="time" class="form-control" id="time" name="time" value="<?php echo $row['time']; ?>">
                </div>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <input type="submit" name="update" value="Update" class="btn btn-success btn-block">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>