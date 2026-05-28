<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM orderdetails WHERE OrderDetailID = ?");
    $stmt->execute([$_GET['id']]);
    echo "OK";
}
?>