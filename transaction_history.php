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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT t.*, u.sender_account_number AS sender_account, u.receiver_account_number AS receiver_account
          FROM transactions t
          INNER JOIN (
              SELECT t.transaction_id, a1.account_number AS sender_account_number, a2.account_number AS receiver_account_number, a1.user_id AS sender_id, a2.user_id AS receiver_id
              FROM transactions t
              INNER JOIN accounts a1 ON t.sender_account_number = a1.account_number
              INNER JOIN accounts a2 ON t.receiver_account_number = a2.account_number
              WHERE a1.user_id = $user_id OR a2.user_id = $user_id
          ) u ON t.transaction_id = u.transaction_id";

$result = $connection->query($query);

if (!$result) {
    die("Error executing query: " . $connection->error);
}

$transactions = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
</head>
<body>
    <h1>Transaction History</h1>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Sender Account</th>
                <th style="padding-left: 20px;">Receiver Account</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction) { ?>
                <tr>
                    <td><?php echo $transaction['transaction_id']; ?></td>
                    <td><?php echo $transaction['transaction_date']; ?></td>
                    <td><?php echo $transaction['amount']; ?></td>
                    <td><?php echo $transaction['sender_account']; ?></td>
                    <td style="padding-left: 20px;"><?php echo $transaction['receiver_account']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
