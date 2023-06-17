<!DOCTYPE html>
<html>
<head>
    <title>Panel pracownika</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="pracownik_style.css">
</head>
<body>

        <header>
          <!-- navbar -->
          <nav>
            <h1>Panel pracownika</h1>
              <ul>
                <li><a href="logout.php">Wyloguj</a></li> 
              </ul>
          </nav>
        </header>

<main>
<div class="dropdown-container">

<!-- zarzadzanie uzytkownikami -->

<button id="dropdown-btn-2" onclick="toggleDropdown('user-management')">Zarządzanie użytkownikami</button>
<section id="user-management">
  <section class="add-user">
  <h2>Zarządzanie użytkownikami</h2>
  <h3>Dodaj użytkownika</h3>
  <form action="add_user.php" method="POST">
    <input type="text" name="name" placeholder="Imie i nazwisko">
    <input type="text" name="phone" placeholder="Telefon">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Hasło">
    
    <input type="submit" value="Dodaj użytkownika">
  </form>
  </section>

  <section class="users-list">
  <h2>Lista użytkowników</h2>
  <table>

    <?php
    
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "aplikacja_bankowa";
    
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    
   
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    // wez dane z bazy
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    
    // wyswietl dane
    if ($result->num_rows > 0) {
      echo "<table>";
      echo "<tr>
      <th>ID</th>
      <th>Imie i nazwisko</th><th>Telefon</th><th>Email</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["user_id"] . "</td>
        <td>" . $row["name"] . "</td>
        <td>" . $row["phone"] . "</td>
        <td>" . $row["email"] . "</td></tr>";
      }
      echo "</table>";
    } else {
      echo "Nie znaleziono użytkowników.";
    }
    $conn->close();
    ?>
  </table>



  <h2>Wybierz użytkownika po ID</h2>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <input type="text" name="user_id" placeholder="ID">
    <input type="submit" value="Znajdź użytkownika">
  </form>
  <?php
  if (isset($_GET['user_id'])) {
   
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "aplikacja_bankowa";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_GET['user_id'];

    // wez dane z bazy
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      ?>
      <!-- wyswietl dane dla user_id -->
      <h2>Dane użytkownika</h2>
      <p><strong>ID:</strong><?php echo $row["user_id"];?></p>
      <p><strong>Imię i nazwisko:</strong> <?php echo $row["name"]; ?></p>
      <p><strong>Telefon:</strong> <?php echo $row["phone"]; ?></p>
      <p><strong>Email:</strong> <?php echo $row["email"]; ?></p>
      <?php
    } else {
      echo "<p>Nie znaleziono użytkownika z takim ID: " . $user_id . "</p>";
    }

    
    $conn->close();
  }
  ?>
</section>
  
  <section class="update-user">
  
  <h2>Zaktualizuj dane użytkownika</h2>
  <form action="update_user.php" method="POST">
    <input type="int" name="user_id" placeholder="ID">
    <input type="name" name="name" placeholder="Nowe Imie i Nazwisko">
    <input type="phone" name="phone" placeholder="Nowy Telefon">
    <input type="email" name="email" placeholder="Nowy Email">
    <input type="submit" value="Zaktualizuj">
  </form>
    </section>

</section>


<!-- transakcje -->
<button id="dropdown-btn-3" onclick="toggleDropdown('transactions')">Historia transakcji</button>
<section id="transactions">
    
<section id="view-history">
    <h3>Historia transakcji</h3>
                    <?php
                // Database connection configuration
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "aplikacja_bankowa";

                // Create a connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // SQL query to fetch transactions from the table
                $sql = "SELECT * FROM transactions";
                $result = $conn->query($sql);

                // Check if there are any records
                if ($result->num_rows > 0) {
                    // Output data in a table format
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Amount</th><th>Date</th><th>Sender</th><th>Receiver</th></tr>";
                    
                    // Loop through each row and display the data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['transaction_id']."</td>";
                        echo "<td>".$row['amount']."</td>";
                        echo "<td>".$row['transaction_date']."</td>";
                        echo "<td>".$row['sender_account_number']."</td>";
                        echo "<td>".$row['receiver_account_number']."</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                } else {
                    echo "No transactions found.";
                }

                // Close the connection
                $conn->close();
                ?>
</section>
</section>


</div>
<!-- skrypt rozwijajacy opcje -->
<script>
  function toggleDropdown(contentId) {
  var dropdownContent = document.getElementById(contentId);
  dropdownContent.classList.toggle("show");
}
</script>


<img src="/images/E-Wallet (HD).png" id="bck-img">


</main>


<!-- stopka -->
<footer>
  <p>&copy; 2023 Technologie internetowe - Julia Kapica, Elene Kajaia
</footer>


</body>
</html>
