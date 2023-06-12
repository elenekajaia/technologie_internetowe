<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="admin_style.css">
</head>
<body>

        <header>
          <nav>
            <h1>Admin Dashboard</h1>
              <ul>
                <li><a href="#">Database Backup</a></li>
                <li><a href="#">Backup Restoration</a></li>
                <li><a href="#">User Management</a></li>
                <li><a href="#">Transactions History</a></li>
                <li><a href="#">Users Accounts</a></li>
                <li><a href="#">Logout</a></li>
              </ul>
          </nav>
        </header>

<main>


    <section class="database-backup">
    <h1>Database Backup</h1>
      <form action="backup.php" method="post">
          <input type="submit" value="Backup Database">
      </form>
    </section>

    <section class="backup-restoration">
    <h1>Backup Restoration</h1>
      <form action="restore.php" method="post" enctype="multipart/form-data">
          <label for="backupFile">Select Encrypted Backup File:</label>
          <input type="file" name="backupFile" id="backupFile" required><br>

          <input type="submit" value="Restore Backup">
      </form>
  </section>
    
    <section class="add-user">
  <h1>User Management</h1>
  <h3>Add User</h3>
  <form action="add_user.php" method="POST">
    <input type="text" name="name" placeholder="Username">
    <input type="text" name="phone" placeholder="phone">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    
    <input type="submit" value="Add User">
  </form>
  </section>

<section class="users-list">
  <h2>Users List</h2>
  <table>

    <?php
    // Connect to the database
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "aplikacja_bankowa";
    
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    // Retrieve users from the database
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    
    // Display users in a table
    if ($result->num_rows > 0) {
      echo "<table>";
      echo "<tr>
      <th>ID</th>
      <th>Username</th><th>Phone</th><th>Email</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["id"] . "</td>
        <td>" . $row["name"] . "</td>
        <td>" . $row["phone"] . "</td>
        <td>" . $row["email"] . "</td></tr>";
      }
      echo "</table>";
    } else {
      echo "No users found.";
    }
    
    // Close the connection
    $conn->close();
    ?>
    
  </table>

  <h2>Get User by ID</h2>
  <form action="get_user.php" method="GET">
  <input type="text" name="user_id" placeholder="User ID">
  <input type="submit" value="Get User">

  <?php
    if (isset($_GET['user_id'])) {
      // Connect to the database
      $servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $dbname = "aplikacja_bankowa";

      $conn = new mysqli($servername, $db_username, $db_password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $user_id = $_GET['user_id'];

      // Retrieve user from the database
      $sql = "SELECT * FROM users WHERE id = $user_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Display user details
        echo "<p><strong>Username:</strong> " . $row["name"] . "</p>";
        echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
      } else {
        echo "<p>No user found with ID: " . $user_id . "</p>";
      }

      // Close the database connection
      $conn->close();
    }
    ?>

</form>
</section>
  
  <section class="update-user">
  <!-- Update User -->
  <h2>Update User</h2>
  <form action="update_user.php" method="POST">
    <input type="int" name="user_id" placeholder="ID">
    <input type="name" name="name" placeholder="New Name">
    <input type="phone" name="phone" placeholder="New Phone">
    <input type="email" name="email" placeholder="New Email">
    <input type="submit" value="Update User">
  </form>
    </section>

    <section class="delete-user">
  <h2>Delete User</h2>
  <form action="delete_user.php" method="POST">
    <input type="int" name="user_id" placeholder="ID">
    <input type="submit" value="Delete User">
  </form>
  </table>
    </section>
    <section class="transactions-history"></section>
    <section class="users-accounts"></section>

   <a href="logout.php">Logout</a>
    

</main>
<footer>
  <p>&copy; 2023 Technologie internetowe - Julia Kapica, Elene Kajaia
</footer>


</body>
</html>
