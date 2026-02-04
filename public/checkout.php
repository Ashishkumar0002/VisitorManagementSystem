<?php
include '../config/config.php';
session_start();

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "UPDATE visitors 
            SET out_time = NOW(), status = 'OUT' 
            WHERE id = $id AND status = 'IN'";

    if (mysqli_query($conn, $sql)) {
        header("Location: current_visitors.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "No visitor selected.";
}
?>
