<?php
// Configuration
$databaseHost = 'localhost';
$databaseName = 'aplikacja_bankowa';
$databaseUser = 'root';
$databasePassword = '';

// Database connection
$mysqli = new mysqli($databaseHost, $databaseUser, $databasePassword, $databaseName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Backup database query
$backupQuery = "mysqldump --user={$databaseUser} --password={$databasePassword} --host={$databaseHost} {$databaseName} > backup.sql";
exec($backupQuery);

// Encryption
$encryptionKey = 'bezpieczenstwo_systemow';
$backupFile = 'backup.sql';
$encryptedFile = 'encrypted_backup.dat';

// Read the backup file
$backupData = file_get_contents($backupFile);

// Encrypt the data
$encryptedData = openssl_encrypt($backupData, 'AES-256-CBC', $encryptionKey, 0, substr(md5('your_iv'), 0, 16));

// Write the encrypted data to a file
file_put_contents($encryptedFile, $encryptedData);

// Cleanup: Delete the plain backup file
unlink($backupFile);

// Output success message
echo "Database backup encrypted and saved to {$encryptedFile}.";
?>
