<?php
include '../config/config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username      = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password  = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_pass  = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password !== $confirm_pass) {
        $message = "New password and confirm password do not match.";
    } else {
        // Check user exists
        $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            // Update password
            $update_sql = "UPDATE users SET password = '$new_password' WHERE username = '$username'";
            if (mysqli_query($conn, $update_sql)) {
                $message = "Password updated successfully. You can now login with your new password.";
            } else {
                $message = "Error while updating password: " . mysqli_error($conn);
            }
        } else {
            $message = "No user found with this username.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - VMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
<div class="login-container">
    <h2>Forgot Password</h2>
    <p style="font-size:13px; margin-bottom:10px;">
        Enter your username and set a new password.
    </p>
    <form method="post" action="">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required>

        <input type="submit" value="Reset Password">
    </form>

    <div style="margin-top:10px; font-size:13px;">
        <a href="login.php">Back to Login</a>
    </div>

    <?php
    if ($message != "") {
        echo "<p class='error' style='margin-top:10px;'>$message</p>";
    }
    ?>
</div>
</body>
</html>
