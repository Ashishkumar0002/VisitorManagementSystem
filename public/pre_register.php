<?php
include '../config/config.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name           = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile         = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email          = mysqli_real_escape_string($conn, $_POST['email']);
    $address        = mysqli_real_escape_string($conn, $_POST['address']);
    $purpose        = mysqli_real_escape_string($conn, $_POST['purpose']);
    $person_to_meet = mysqli_real_escape_string($conn, $_POST['person_to_meet']);
    $department     = mysqli_real_escape_string($conn, $_POST['department']);
    $visit_date     = mysqli_real_escape_string($conn, $_POST['visit_date']);

    $sql = "INSERT INTO pre_registrations
        (name, mobile, email, address, purpose, person_to_meet, department, visit_date)
        VALUES
        ('$name', '$mobile', '$email', '$address', '$purpose', '$person_to_meet', '$department', '$visit_date')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Your visit request has been submitted. Please wait for approval.";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visitor Pre-Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
<div class="login-container">
    <h2>Visitor Pre-Registration</h2>
    <?php if ($msg != "") echo "<p class='error' style='color:green;'>$msg</p>"; ?>
    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Mobile:</label>
        <input type="text" name="mobile">

        <label>Email:</label>
        <input type="email" name="email">

        <label>Address:</label>
        <input type="text" name="address">

        <label>Purpose of Visit:</label>
        <input type="text" name="purpose" required>

        <label>Person to Meet:</label>
        <input type="text" name="person_to_meet" required>

        <label>Department:</label>
        <input type="text" name="department">

        <label>Visit Date:</label>
        <input type="date" name="visit_date" required>

        <input type="submit" value="Submit Request">
    </form>
</div>
</body>
</html>
