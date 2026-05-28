<?php
include '../includes/db.php';

if (isset($_POST['OrderDetailID'])) {
    $stmt = $conn->prepare("UPDATE orderdetails SET OrderID = ?, ProductID = ?, Quantity = ? WHERE OrderDetailID = ?");
    $stmt->execute([
        $_POST['OrderID'],
        $_POST['ProductID'],
        $_POST['Quantity'],
        $_POST['OrderDetailID']
    ]);
    echo "OK";
}
?>