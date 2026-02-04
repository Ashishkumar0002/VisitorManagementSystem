<?php
include '../config/config.php';

if (!isset($_GET['id'])) {
    die("Visitor ID missing");
}

$id = (int) $_GET['id'];
$qr_text = "VMS-" . $id . "-" . date('Ymd');

// Just save QR text instead of image
mysqli_query($conn, "UPDATE visitors SET qr_code_path='$qr_text' WHERE id=$id");

header("Location: visitors_history.php");
exit();
?>
