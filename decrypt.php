<?php
// Encryption settings
$encryptionMethod = "AES-256-CBC";
$encryptionKey = "bezpieczenstwo_systemow";

// Check if a file was uploaded
if(isset($_FILES['backupFile'])) {
    $file = $_FILES['backupFile'];

    // Check for any errors during file upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("File upload error: " . $file['error']);
    }

    // Read the uploaded file content
    $encryptedContent = file_get_contents($file['tmp_name']);

    // Decrypt the backup content
    $decryptedContent = openssl_decrypt($encryptedContent, $encryptionMethod, $encryptionKey, 0, random_bytes(16));

    // Write the decrypted content to a new file or restore it to the database
    $decryptedBackupFile = 'decrypted.txt';
    if (file_put_contents($decryptedBackupFile, $decryptedContent) === false) {
        die("Failed to write decrypted backup file");
    }

    echo "Backup file decrypted successfully.";
}
?>
