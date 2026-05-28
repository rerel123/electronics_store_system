<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    try {
        $sql = "DELETE FROM orders WHERE OrderID = :OrderID";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':OrderID' => $_GET['id']]);
        echo "Success";
    } catch (PDOException $e) {
        echo "Delete Failed: " . $e->getMessage();
    }
}
?>