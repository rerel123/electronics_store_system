<?php
include '../includes/db.php';

if (isset($_POST['SupplierID'])) {
    $stmt = $conn->prepare("UPDATE suppliers SET SupplierName = ?, ContactName = ?, Address = ?, City = ?, Country = ?, Phone = ? WHERE SupplierID = ?");
    $stmt->execute([
        $_POST['SupplierName'],
        $_POST['ContactName'],
        $_POST['Address'],
        $_POST['City'],
        $_POST['Country'],
        $_POST['Phone'],
        $_POST['SupplierID']
    ]);
    echo "OK";
}
?>