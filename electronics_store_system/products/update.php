<?php
include '../includes/db.php';

if (isset($_POST['ProductID'])) {
    $sql = "UPDATE products SET 
                ProductName = ?, SupplierID = ?, CategoryID = ?, Unit = ?, Price = ? 
            WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['ProductName'],
        $_POST['SupplierID'],
        $_POST['CategoryID'],
        $_POST['Unit'],
        $_POST['Price'],
        $_POST['ProductID']
    ]);
    echo "OK";
}
?>