<?php
session_start();
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'aplikacja_bankowa';

$connection = new mysqli($host, $username, $password, $database);
if ($connection->connect_errno) {
    die("Failed to connect to MySQL: " . $connection->connect_error);
}


$email = $_POST['email'];
$password = $_POST['password'];



// ---------generuj numer konta------------
function generateAccountNumber() {

    $accountNumber = "AC" . rand(100000000, 999999999);
    return $accountNumber;
}

//odczytanie hashowanego hasla
function hashPassword($password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    return $hashedPassword;
}
//weryfikacja hasla
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}


// ---------------przekierowanie--------------
function redirect($role) {
    if ($role ==='admin') {
        header("Location: admin.php");
        exit();
    }
    else {
        header("Location: main.php");
        exit();
    }

}

// ----------------logowanie----------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
//wez dane z formularza
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $connection->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['user_id']; //pobiera id i wrzuca do
       
        $hashedPassword = $row["password"];
        $role = $row["role"];
//weryfikacja hasla
        if (verifyPassword($password, $hashedPassword)) {
//przekierowanie zgodnie z rola
            redirect($role);
        } else {
            echo "Niepoprawne hasło";
        }
    } else {

        echo "Niepoprawny login";
    }
}


$connection->close();
?>
