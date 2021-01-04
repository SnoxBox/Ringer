<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ips";

$con = mysqli_connect($servername, $username, $password, $dbname) or die(mysqli_error($con));
mysqli_select_db($con, $dbname) or die(mysqli_error($con));

// Connect to database
$db = $con;

//Connect to database
$conn = $con;
global $conn;
echo '<link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
?>
