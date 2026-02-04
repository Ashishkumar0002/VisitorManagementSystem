<?php
session_start();
include '../config/config.php';

// If already logged in, go to dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>VMS Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
<div class="login-container">
    

    <h2>Visitor Management System</h2>
    <form method="post" action="">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Login">
    </form>
<div class="login-logo-left">
    <img src="assets/logo/logo.jpeg" alt="University Logo">
</div>


    <div style="margin-top:10px; text-align:right; font-size:13px;">
        <a href="forgot_password.php">Forgot Password?</a>
    </div>

    <?php if ($error != "") { echo "<p class='error'>$error</p>"; } ?>
</div>
</body>
</html>
