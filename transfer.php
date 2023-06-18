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
    $fromAccount = $_SESSION['account_number'];
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

            $transactionTypeId = 1; // Assuming 1 represents transfer transactions
            $transactionDate = date("Y-m-d H:i:s");

            // Prepare and execute the INSERT statement
            $stmt = $connection->prepare("INSERT INTO transactions (transaction_type_id, amount, transaction_date, sender_account_number, receiver_account_number) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("dssss", $transactionTypeId, $amount, $transactionDate, $fromAccount, $toAccount);
            $stmt->execute();
            $stmt->close();
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
