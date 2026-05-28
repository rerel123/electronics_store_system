<?php
header('Content-Type: application/json');
include '../includes/db.php';

try {
    // Siguroha nga husto ang ngalan sa imong table ug columns (e.g., customers)
    $stmt = $conn->prepare("SELECT CustomerID, CustomerName, City FROM customers ORDER BY CustomerID ASC");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database failure: ' . $e->getMessage()
    ]);
}
?>