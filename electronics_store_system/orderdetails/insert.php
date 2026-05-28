<?php
include '../includes/db.php';

if (isset($_POST['OrderID'])) {
    $stmt = $conn->prepare("INSERT INTO orderdetails (OrderID, ProductID, Quantity) VALUES (?, ?, ?)");
    $stmt->execute([
        $_POST['OrderID'],
        $_POST['ProductID'],
        $_POST['Quantity']
    ]);
    echo "OK";
}
?>