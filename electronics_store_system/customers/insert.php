<?php
header('Content-Type: application/json');
include '../includes/db.php';

if (isset($_POST['CustomerName']) && isset($_POST['City'])) {
    $name = trim($_POST['CustomerName']);
    $city = trim($_POST['City']);

    if (empty($name) || empty($city)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO customers (CustomerName, City) VALUES (:name, :city)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':city', $city);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Customer added cleanly!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute query operation.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request payload architecture.']);
}
?>