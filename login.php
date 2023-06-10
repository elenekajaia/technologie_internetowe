<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'aplikacja_bankowa';

// Establish database connection
$connection = new mysqli($host, $username, $password, $database);
if ($connection->connect_errno) {
    die("Failed to connect to MySQL: " . $connection->connect_error);
}

// Get the entered username and password
$name = $_POST['name'];
$pass = $_POST['pass'];

// Query the database to check admin credentials
$query = "SELECT * FROM admins WHERE name = '$name' AND pass = '$pass'";
$result = $connection->query($query);

if ($result->num_rows == 1) {
    // Admin login successful
    session_start();
    $_SESSION['name'] = $name;
    header("Location: admin.html"); // Redirect to the admin dashboard or desired page
} else {
    // Admin login failed
    echo "Invalid username or password";
}

// Close the database connection
$connection->close();
?>
