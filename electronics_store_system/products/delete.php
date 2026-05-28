<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM products WHERE ProductID = ?");
    $stmt->execute([$_GET['id']]);
    echo "OK";
}
?>