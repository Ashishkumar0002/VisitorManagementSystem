<?php
// Is file ko include karne se pehle session_start() ho chuka hoga

function require_role($allowed_roles = []) {
    if (!isset($_SESSION['role'])) {
        header("Location: login.php");
        exit();
    }
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        // Access deny simple message
        echo "<div style='padding:20px; font-family:Arial;'>
                <h2 style='color:red;'>Access Denied</h2>
                <p>You do not have permission to access this page.</p>
                <a href='dashboard.php' style='display:inline-block; margin-top:10px; padding:8px 14px; background:#333; color:#fff; text-decoration:none; border-radius:4px;'>
                    Go to Dashboard
                </a>
              </div>";
        exit();
    }
}
