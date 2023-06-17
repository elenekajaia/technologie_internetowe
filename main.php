<?php 
session_start();
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
      echo"<p>witaj Twoje ID to ".$_SESSION['user_id']."!";
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
      
          echo "<p>Saldo pozostałe na twoim koncie: " . $balance." PLN";
      } else {
          echo "Failed to retrieve balance.";
      }
      
      $connection->close();
    ?>

<h2>Przelew między kontami</h2>
        <form action="transfer.php" method="post">
            <label for="from_account">Numer konta źródłowego:</label>
            <input type="text" id="from_account" name="from_account" required><br>

            <label for="to_account">Numer konta docelowego:</label>
            <input type="text" id="to_account" name="to_account" required><br>

            <label for="amount">Kwota:</label>
            <input type="number" id="amount" name="amount" min="0" step="0.01" required><br>

            <input type="submit" name="transfer" value="Przelej">
        </form>
        </main>

        <!-- stopka -->
        <footer>
            <p>&copy; 2023 Technologie internetowe - Julia Kapica, Elene Kajaia
          </footer>
          
</body>
</html>