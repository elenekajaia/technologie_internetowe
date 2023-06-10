<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'aplikacja_bankowa';

// Backup file path and name
$backupFile = 'backup.sql';

// Encryption settings
$encryptionMethod = "AES-256-CBC";
$encryptionKey = "bezpieczenstwo_systemow";

// Connect to the database
$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_errno) {
    die("Failed to connect to MySQL: " . $connection->connect_error);
}

// Backup the database
$query = "SELECT * FROM users";
$result = $connection->query($query);

if (!$result) {
    die("Backup query failed: " . $connection->error);
}

// Generate backup file content
$backupContent = '';
while ($row = $result->fetch_assoc()) {
    // Format the row data as SQL insert statements
    $insertStatement = "INSERT INTO users (id, email, ...) VALUES ('" . $row['id'] . "', '" . $row['email'] . "', ...);";
    $backupContent .= $insertStatement . "\n";
}

// Encrypt the backup content
$encryptedContent = openssl_encrypt($backupContent, $encryptionMethod, $encryptionKey, 0, random_bytes(16));

// Write the encrypted backup content to a file
if (file_put_contents($backupFile, $encryptedContent) === false) {
    die("Failed to write backup file");
}

// Close the database connection
$connection->close();

echo "Backup completed successfully.";
?>
