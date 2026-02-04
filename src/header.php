<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../public/login.php");
    exit();
}

include 'auth.php'; // role helper functions

$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visitor Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="navbar">
    <img src="../assets/logo/logo.jpeg" alt="University Logo">
    <strong>Visitor Management System</strong>

    <div class="nav-links">
        <!-- Admin / Office Admin / Gate Admin: Dashboard -->
        <a href="../public/dashboard.php">Dashboard</a>

        <?php if (in_array($role, ['admin', 'gate_admin'])): ?>
            <a href="../public/add_visitor.php">Add Visitor</a>
            <a href="../public/current_visitors.php">Current Visitors</a>
        <?php endif; ?>

        <!-- History sab dekh sakte hain -->
        <a href="../public/visitors_history.php">All Visitors</a>

        <?php if (in_array($role, ['admin', 'office_admin'])): ?>
            <a href="../public/reports.php">Reports</a>
            <a href="../public/blacklist.php">Blacklist</a>
        <?php endif; ?>

        <!-- Future: HOD specific link (optional) -->
        <?php if ($role == 'hod'): ?>
            <!-- Agar HOD ke liye special page banaya to yaha link aa sakta hai -->
            <!-- <a href="../public/hod_visitors.php">My Department Visitors</a> -->
        <?php endif; ?>

        <a href="../public/logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a>
    </div>
</div>
<div class="page-container">
