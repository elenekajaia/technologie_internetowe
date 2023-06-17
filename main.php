<?php
session_start();

// Check if the "show_history" button was clicked
if (isset($_POST['show_history'])) {
    $_SESSION['show_history'] = true;
} elseif (isset($_POST['hide_history'])) {
    // If the "hide_history" button was clicked, unset the session variable to hide the transaction history
    unset($_SESSION['show_history']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mainstyle.css">
    <title>Aplikacja bankowa</title>
</head>
<body>
    <header>
        <!-- navbar -->
        <nav>
            <h1>Aplikacja bankowa</h1>
            <ul>
                <li><a href="logout.php">Wyloguj</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        echo "<p> Twoje ID to " . $_SESSION['user_id'] . "  (do szybkiego sprawdzenie w bazie danych, będzie usunięte pozniej)";
        echo "<p>WITAMY twoj numer konta to " . $_SESSION['account_number'];

        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'aplikacja_bankowa';

        $connection = new mysqli($host, $username, $password, $database);
        if ($connection->connect_errno) {
            die("Failed to connect to MySQL: " . $connection->connect_error);
        }

        if (!isset($_SESSION['user_id'])) {
            // User is not logged in, redirect them to the login page or display an error message
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // Retrieve the balance from the accounts table
        $sql = "SELECT balance FROM accounts WHERE user_id = $user_id";
        $result = $connection->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $balance = $row['balance'];

            echo "<p>Saldo pozostałe na twoim koncie: " . $balance . " PLN";
        } else {
            echo "Failed to retrieve balance.";
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

        $connection->close();
        ?>

        <h2>Przelew między kontami</h2>
        <form action="transfer.php" method="post">
            <!-- Removed the "from_account" input field -->
            <input type="hidden" name="from_account" value="<?php echo $_SESSION['account_number']; ?>">

            <label for="to_account">Numer konta docelowego:</label>
            <input type="text" id="to_account" name="to_account" required><br>

            <label for="amount">Kwota:</label>
            <input type="number" id="amount" name="amount" min="0" step="0.01" required><br>

            <input type="submit" name="transfer" value="Przelej">
        </form>

        <form action="" method="post">
            <?php if (!isset($_SESSION['show_history'])) { ?>
                <button type="submit" name="show_history">Show Transaction History</button>
            <?php } else { ?>
                <button type="submit" name="hide_history">Hide Transaction History</button>
            <?php } ?>
        </form>

        <?php if (isset($_SESSION['show_history'])) { ?>
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
        <?php } ?>
    </main>

    <!-- stopka -->
    <footer>
        <p>&copy; 2023 Technologie internetowe - Julia Kapica, Elene Kajaia</p>
    </footer>
</body>
</html>
