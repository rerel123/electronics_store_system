<?php
include '../includes/db.php';

$stmt = $conn->prepare("SELECT CategoryID, CategoryName, Description FROM categories ORDER BY CategoryID aSC");
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>