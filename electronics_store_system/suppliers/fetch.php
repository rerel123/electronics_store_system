<?php
include '../includes/db.php';
$stmt = $conn->prepare("SELECT * FROM suppliers ORDER BY SupplierID ASC");
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>