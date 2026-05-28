<?php
include '../includes/db.php';
$stmt = $conn->prepare("SELECT * FROM employees ORDER BY EmployeeID aSC");
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>