<?php
header('Content-Type: application/json');
include '../includes/db.php';

if (isset($_POST['CustomerID']) && isset($_POST['CustomerName']) && isset($_POST['City'])) {
    $id = intval($_POST['CustomerID']);
    $name = trim($_POST['CustomerName']);
    $city = trim($_POST['City']);

    if (empty($name) || empty($city)) {
        echo json_encode(['status' => 'error', 'message' => 'Form parameters cannot be blank.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE customers SET CustomerName = :name, City = :city WHERE CustomerID = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Record successfully altered.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No rows were affected.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'SQL Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete data layer variables.']);
}
?>