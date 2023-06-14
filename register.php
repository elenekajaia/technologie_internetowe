<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikacja_bankowa";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

//wez dane z formularza
if (isset($_POST['send'])) {

    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $hash = password_hash($password, PASSWORD_BCRYPT);

 //wysklij dane do bazy
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, phone, email, password, role) VALUES (?, ?, ?, ?, 'client')");
    mysqli_stmt_bind_param($stmt, 'siss', $name, $phone, $email, $hash);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

?>

