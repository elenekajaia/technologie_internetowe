<?php
// Retrieve user ID from the form
$user_id = $_POST['user_id'];

// Connect to the database
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "aplikacja_bankowa";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the DELETE statement
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

// Close the statement and connection
$stmt->close();
$conn->close();

header("Location: admin.php");
?>
