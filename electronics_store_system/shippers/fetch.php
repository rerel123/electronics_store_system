<?php
include '../includes/db.php';
$stmt = $conn->prepare("SELECT * FROM shippers ORDER BY ShipperID ASC");
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>