<?php
header('Content-Type: application/json');
include '../includes/db.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    try {
        $stmt = $conn->prepare("DELETE FROM customers WHERE CustomerID = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Customer permanently dropped.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to drop record item.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Constraint Failure or SQL Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Payload targeting variable missing.']);
}
?>