<?php
include '../includes/db.php';

if (isset($_POST['SupplierName'])) {
    $stmt = $conn->prepare("INSERT INTO suppliers (SupplierName, ContactName, Address, City, Country, Phone) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['SupplierName'],
        $_POST['ContactName'],
        $_POST['Address'],
        $_POST['City'],
        $_POST['Country'],
        $_POST['Phone']
    ]);
    echo "OK";
}
?>