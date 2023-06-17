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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['transfer'])) {
    $fromAccount = $_POST["from_account"];
    $toAccount = $_POST["to_account"];
    $amount = $_POST["amount"];

    $sql = "SELECT balance FROM accounts WHERE account_number = '$fromAccount'";
    $result = $connection->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $balance = $row["balance"];

        if ($balance >= $amount) {
            $newBalanceFrom = $balance - $amount;
            $newBalanceTo = $balance + $amount;

            $sql = "UPDATE accounts SET balance = '$newBalanceFrom' WHERE account_number = '$fromAccount'";
            $connection->query($sql);

            $sql = "UPDATE accounts SET balance = '$newBalanceTo' WHERE account_number = '$toAccount'";
            $connection->query($sql);

            echo "Przelew wykonany pomyślnie.";
        } else {
            echo "Niewystarczające środki na koncie.";
        }
    } else {
        echo "Niepoprawny numer konta.";
    }
}

$connection->close();
?>
