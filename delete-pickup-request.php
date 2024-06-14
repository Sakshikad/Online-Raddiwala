<?php session_start();

if(!isset($_SESSION['valid'])) {
	header('Location: signin.php');
}

include("config.php");
$id = $_GET['id'];

$result=mysqli_query($conn, "DELETE FROM pickup WHERE id=$id");

header("Location:profile.php");
?>

