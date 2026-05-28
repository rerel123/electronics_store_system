<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM suppliers WHERE SupplierID = ?");
    $stmt->execute([$_GET['id']]);
    echo "OK";
}
?>