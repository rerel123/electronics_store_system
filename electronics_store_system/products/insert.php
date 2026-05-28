<?php
include '../includes/db.php';

if (isset($_POST['ProductName'])) {
    $stmt = $conn->prepare("INSERT INTO products (ProductName, SupplierID, CategoryID, Unit, Price) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['ProductName'],
        $_POST['SupplierID'],
        $_POST['CategoryID'],
        $_POST['Unit'],
        $_POST['Price']
    ]);
    echo "OK";
}
?>