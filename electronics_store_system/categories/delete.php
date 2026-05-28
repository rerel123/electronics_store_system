<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE CategoryID = ?");
    $stmt->execute([$_GET['id']]);
    
    echo "OK";
}
?>