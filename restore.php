<?php

$databaseHost = 'localhost';
$databaseName = 'aplikacja_bankowa';
$databaseUser = 'root';
$databasePassword = '';

//dane do szyfrowania
$encryptionKey = 'bezpieczenstwo_systemow';
$encryptedFile = 'encrypted_backup.dat';
$decryptedFile = 'decrypted_backup.sql';
//nic
//odczyt szyfrowanych danych
$encryptedData = file_get_contents($encryptedFile);

//odszyfrowanie danych
$decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $encryptionKey, 0, substr(hash('sha256','your_iv'), 0, 16));

// zapis odszyfrowanych danych do pliku
file_put_contents($decryptedFile, $decryptedData);


$mysqli = new mysqli($databaseHost, $databaseUser, $databasePassword, $databaseName);


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

//odzyskanie bazy z odszyfrowanego backupu
$restoreQuery = "mysql --user={$databaseUser} --password={$databasePassword} --host={$databaseHost} {$databaseName} < {$decryptedFile}";
exec($restoreQuery);

//usuniecie danych z pliku
unlink($decryptedFile);

echo "Database backup decrypted and restored.";

header("Location: admin.php");
?>
