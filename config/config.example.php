<?php
/**
 * Visitor Management System - Configuration File
 * 
 * Copy this file to config.php and update with your database credentials
 * Never commit config.php to version control - it contains sensitive data
 */

// Database Configuration
$host = "localhost";        // Database host
$user = "root";             // Database user (default for XAMPP)
$pass = "";                 // Database password (default is empty for XAMPP)
$db   = "visitor_db";       // Database name

// Establish database connection
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");

// Application Configuration
define('APP_NAME', 'Visitor Management System');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/VMS/');

// Upload directories
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('QRCODE_DIR', __DIR__ . '/../assets/qrcodes/');

// Time zone
date_default_timezone_set('UTC');
?>
