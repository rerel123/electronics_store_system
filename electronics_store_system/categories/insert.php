<?php
include '../includes/db.php';

if (isset($_POST['CategoryName'])) {
    $stmt = $conn->prepare("INSERT INTO categories (CategoryName, Description) VALUES (?, ?)");
    $stmt->execute([
        $_POST['CategoryName'],
        $_POST['Description']
    ]);
    
    echo "OK";
}
?>