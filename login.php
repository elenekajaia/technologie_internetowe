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

    //wstrzykiwanie SQL próba jeden
    // $email = htmlentities($email,ENT_QUOTES,"UTF-8");
    // $password = htmlentities($password,ENT_QUOTES,"UTF-8");


//wez dane z formularza
    // wstrzykiwanie SQL - Prepare and bind the parameter
    $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['user_id']; //pobiera id i wrzuca do
       //ma pobrac tez account number
       $user_id = $row['user_id'];

      // wstrzykiwanie SQL - Prepare and bind the parameter
        $stmt = $connection->prepare("SELECT account_number FROM accounts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $account_result = $stmt->get_result();

    if ($account_result->num_rows == 1) {
        $account_row = $account_result->fetch_assoc();
        $account_number = $account_row['account_number'];
        // Store the account number in the session or use it as needed
        $_SESSION['account_number'] = $account_number;
    }



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
