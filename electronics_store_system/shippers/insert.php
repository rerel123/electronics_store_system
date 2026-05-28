<?php
include '../includes/db.php';
if (isset($_POST['ShipperName'])) {
    $stmt = $conn->prepare("INSERT INTO shippers (ShipperName, Phone) VALUES (?, ?)");
    $stmt->execute([$_POST['ShipperName'], $_POST['Phone']]);
    echo "OK";
}
?>