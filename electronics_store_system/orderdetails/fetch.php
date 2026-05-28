<?php
include '../includes/db.php';
$stmt = $conn->prepare("SELECT * FROM orderdetails ORDER BY OrderDetailID ASC");
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>