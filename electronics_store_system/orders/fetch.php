<?php
include '../includes/db.php';

$sql = "SELECT OrderID, CustomerID, EmployeeID, OrderDate, ShipperID 
        FROM orders 
        ORDER BY OrderID ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>