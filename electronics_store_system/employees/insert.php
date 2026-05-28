<?php
include '../includes/db.php';

if (isset($_POST['FirstName'])) {
    $stmt = $conn->prepare("INSERT INTO employees (FirstName, LastName, BirthDate, Roles) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['FirstName'],
        $_POST['LastName'],
        $_POST['BirthDate'],
        $_POST['Roles']
    ]);
    echo "OK";
}
?>