<?php
// Configuration
$databaseHost = 'localhost';
$databaseName = 'aplikacja_bankowa';
$databaseUser = 'root';
$databasePassword = '';

// Encryption
$encryptionKey = 'bezpieczenstwo_systemow';
$encryptedFile = 'encrypted_backup.dat';
$decryptedFile = 'decrypted_backup.sql';

// Read the encrypted backup file
$encryptedData = file_get_contents($encryptedFile);

// Decrypt the data
$decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $encryptionKey, 0, substr(md5('your_iv'), 0, 16));

// Write the decrypted data to a file
file_put_contents($decryptedFile, $decryptedData);

// Database connection
$mysqli = new mysqli($databaseHost, $databaseUser, $databasePassword, $databaseName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Restore database query
$restoreQuery = "mysql --user={$databaseUser} --password={$databasePassword} --host={$databaseHost} {$databaseName} < {$decryptedFile}";
exec($restoreQuery);

// Cleanup: Delete the decrypted backup file
unlink($decryptedFile);

// Output success message
echo "Database backup decrypted and restored.";
?>
