<!DOCTYPE html>
<html>
<head>
    <title>Panel admina</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="admin_style.css">
</head>
<body>

        <header>
          <!-- navbar -->
          <nav>
            <h1>Panel admina</h1>
              <ul>
                <li><a href="logout.php">Wyloguj</a></li> 
              </ul>
          </nav>
        </header>

<main>
<div class="dropdown-container">


<!-- zarzadzanie baza danych -->
<button id="dropdown-btn-1" onclick="toggleDropdown('backup-container')">Zarządzanie bazą danych</button>

<section id="backup-container">
    <section class="database-backup">
    <h1>Backup</h1>
      <form action="backup.php" method="post">
          <input type="submit" value="Zrób backup bazy danych" id="btn">
      </form>
    </section>
<hr class="hr-blur">
    <section class="backup-restoration">
    <h1>Odzyskiwanie bazy danych</h1>
      <form action="restore.php" method="post" enctype="multipart/form-data">
          <label for="backupFile">Wybierz zaszyfrowany plik z bazą danych:</label>
          <input type="file" name="backupFile" id="backupFile" id="btn" required><br>

          <input type="submit" value="Odzyskaj" id="btn">
      </form>
  </section>
</section>

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
    
    <input type="submit" value="Dodaj użytkownika" id="btn">
  </form>
  </section>

  <section class="users-list">
  <h3>Lista użytkowników</h3>
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
  <h3>Wybierz użytkownika po ID</h3>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <input type="text" name="user_id" placeholder="ID">
    <input type="submit" value="Znajdź użytkownika" id="btn">
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
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
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
  
  <h3>Zaktualizuj dane użytkownika</h3>
  <form action="update_user.php" method="POST">
    <input type="int" name="user_id" placeholder="ID">
    <input type="name" name="name" placeholder="Nowe Imie i Nazwisko">
    <input type="phone" name="phone" placeholder="Nowy Telefon">
    <input type="email" name="email" placeholder="Nowy Email">
    <input type="submit" value="Zaktualizuj" id="btn">
  </form>
    </section>

    <section class="delete-user">
    <h2>Usuń użytkownika</h2>
    <form action="delete_user.php" method="POST">
    <input type="int" name="user_id" placeholder="ID">
    <input type="submit" value="Usuń" id="btn">
  </form>
    </table>
    </section>
</section>



<button id="dropdown-btn-3" onclick="toggleDropdown('transactions')">Transakcje</button>
<section id="transactions">
  <h2>Historia transakcji</h2>
<?php
                
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "aplikacja_bankowa";

               
                $conn = new mysqli($servername, $username, $password, $database);

                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

              //  weż dane z tabeli
                $sql = "SELECT * FROM transactions";
                $result = $conn->query($sql);

                // sprawdz czy sa rekordy w tabeli
                if ($result->num_rows > 0) {
                    // wyswietl w ten sposob
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Amount</th><th>Date</th><th>Sender</th><th>Receiver</th></tr>";
                    
                    // wyswietl dane
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

               
                $conn->close();
                ?>
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
