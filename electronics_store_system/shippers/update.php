<?php
include '../includes/db.php';
if (isset($_POST['ShipperID'])) {
    $stmt = $conn->prepare("UPDATE shippers SET ShipperName = ?, Phone = ? WHERE ShipperID = ?");
    $stmt->execute([$_POST['ShipperName'], $_POST['Phone'], $_POST['ShipperID']]);
    echo "OK";
}
?>