<?php
$host = "localhost";
$user = "root";      // default for XAMPP
$pass = "";          // default is empty
$db   = "visitor_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
