<?php

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_BCRYPT);

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "aplikacja_bankowa";


$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// dodawanie uzytkownika do bazy danych

$stmt = $conn->prepare("INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss",$name, $phone, $email, $hash);
$stmt->execute();


$stmt->close();
$conn->close();

header("Location: admin.php");
?>
