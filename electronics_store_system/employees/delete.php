<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM employees WHERE EmployeeID = ?");
    $stmt->execute([$_GET['id']]);
    echo "OK";
}
?>