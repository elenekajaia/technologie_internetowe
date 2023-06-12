<?php
// Retrieve user details from the form
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_BCRYPT);

// Perform necessary validations

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

// Prepare and execute the INSERT statement
$stmt = $conn->prepare("INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss",$name, $phone, $email, $hash);
$stmt->execute();

// Close the statement and connection
$stmt->close();
$conn->close();

header("Location: admin.php");
?>
