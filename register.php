<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikacja_bankowa";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

// Process form submission
if (isset($_POST['send'])) {

    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $hash = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'siss', $name, $phone, $email, $hash);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        header("Location: main.html");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close MySQL connection
mysqli_close($conn);

?>

