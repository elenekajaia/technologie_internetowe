<?php
//wez dane z formularza
$user_id = $_POST['user_id'];
$new_name = $_POST['name'];
$new_phone = $_POST['phone'];
$new_email = $_POST['email'];

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "aplikacja_bankowa";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//funkcja wysylajaca dane do bazy
$stmt = $conn->prepare("UPDATE users SET  name=?, phone=?, email = ? WHERE user_id = ?");
$stmt->bind_param("sisi", $new_name, $new_phone, $new_email, $user_id);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: admin.php");
?>
