<?php
include '../includes/db.php';

// Removed LEFT JOINs to fetch raw values directly from the products table
$sql = "SELECT * 
        FROM products 
        ORDER BY ProductID ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>