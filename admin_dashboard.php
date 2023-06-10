<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin.html"); // Redirect to the login page if not logged in
    exit();
}

// Display the admin dashboard
echo "Welcome, " . $_SESSION['admin_username'] . "! This is the admin dashboard.";
?>
