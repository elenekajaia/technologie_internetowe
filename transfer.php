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
// pobranie danych z formularza przelewu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['transfer'])) {
    $fromAccount = $_SESSION['account_number'];
    $toAccount = $_POST["to_account"];
    $amount = $_POST["amount"];
// przeslanie danych do bazy
    $sql = "SELECT balance FROM accounts WHERE account_number = '$fromAccount'";
    $result = $connection->query($sql);
// sprawdzenie salda
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $balance = $row["balance"];
// weryfikacja czy przelew moze zostac wykonany na podst wielkosci salda
        if ($balance >= $amount) {
            $newBalanceFrom = $balance - $amount;
            $newBalanceTo = $balance + $amount;
// aktualizacja danych w bazie po wykonaniu przelewu
            $sql = "UPDATE accounts SET balance = '$newBalanceFrom' WHERE account_number = '$fromAccount'";
            $connection->query($sql);
// aktualizacja danych w bazie po wykonaniu przelewu
            $sql = "UPDATE accounts SET balance = '$newBalanceTo' WHERE account_number = '$toAccount'";
            $connection->query($sql);

            $transactionTypeId = 1; // zakladamy ze id - 1 to jest przelew
            $transactionDate = date("Y-m-d H:i:s"); //sposob w jaki zapisujemy dane w bazie w kolumnie data

            // statement dodawania rekordu do tabeli transakcje
            $stmt = $connection->prepare("INSERT INTO transactions (transaction_type_id, amount, transaction_date, sender_account_number, receiver_account_number) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("dssss", $transactionTypeId, $amount, $transactionDate, $fromAccount, $toAccount);
            $stmt->execute();
            $stmt->close();
            $_SESSION['transfer_message'] = "Przelew wykonany pomyślnie.";
        } else {
            $_SESSION['transfer_message'] = "Niewystarczające środki na koncie.";
        }
    } else {
        echo "Niepoprawny numer konta.";
    }
}

$connection->close();
header("Location: main.php");


?>
