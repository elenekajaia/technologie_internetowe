<?php
// Retrieve user details from the form
$user_id = $_POST['user_id'];
$new_name = $_POST['name'];
$new_phone = $_POST['phone'];
$new_email = $_POST['email'];

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

// Prepare and execute the UPDATE statement
$stmt = $conn->prepare("UPDATE users SET  name=?, phone=?, email = ? WHERE id = ?");
$stmt->bind_param("sisi", $new_name, $new_phone, $new_email, $user_id);
$stmt->execute();

// Close the statement and connection
$stmt->close();
$conn->close();

header("Location: admin.php");
?>
