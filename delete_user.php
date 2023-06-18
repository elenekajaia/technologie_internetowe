<?php
//dane z formularza
$user_id = $_POST['user_id'];


$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "aplikacja_bankowa";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//usuniecie usera z bazy danych
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: admin.php");
?>
