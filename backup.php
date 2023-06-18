<?php
$databaseHost = 'localhost';
$databaseName = 'aplikacja_bankowa';
$databaseUser = 'root';
$databasePassword = '';

$mysqli = new mysqli($databaseHost, $databaseUser, $databasePassword, $databaseName);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
//nic
// dane do szyfrowania
$encryptionKey = 'bezpieczenstwo_systemow';
$backupFile = 'backup.sql';
$encryptedFile = 'encrypted_backup.dat';

// zapisanie bazy danych do pliku
$backupQuery = "mysqldump --user={$databaseUser} --password={$databasePassword} --host={$databaseHost} {$databaseName} > {$backupFile}";
exec($backupQuery);

// odczyt backupu
$backupData = file_get_contents($backupFile);

// zaszyfrowanie danych
$encryptedData = openssl_encrypt($backupData, 'AES-256-CBC', $encryptionKey, 0, substr(hash('sha256','your_iv'), 0, 16));

// zapis zaszyfrowanych danych do pliku
file_put_contents($encryptedFile, $encryptedData);

// usuniecie danych z pliku
unlink($backupFile);

echo "Database backup encrypted and saved to {$encryptedFile}.";

header("Location: admin.php");
?>
