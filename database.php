<?php
/* 
Create config.php file and add the configuration code in it
<?php
$db['host'] = "localhost"; // Host name
$db['user'] = "root"; // Mysql username
$db['pass'] = "YourPassword"; // Mysql password
$db['name'] = "YourDBname"; // Database name
?>
*/
// Include configuration
// include('config.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikacja_bankowa";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

// Process form submission
if (isset($_POST['send'])) {

    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $pass = htmlspecialchars($_POST['pass']);
    $hash = password_hash($pass, PASSWORD_BCRYPT);

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, phone, email, pass) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $phone, $email, $hash);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close MySQL connection
mysqli_close($conn);

?>

