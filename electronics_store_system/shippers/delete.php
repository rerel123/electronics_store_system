<?php
include '../includes/db.php';
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM shippers WHERE ShipperID = ?");
    $stmt->execute([$_GET['id']]);
    echo "OK";
}
?>