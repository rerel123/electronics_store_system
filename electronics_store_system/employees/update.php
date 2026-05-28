<?php
include '../includes/db.php';

if (isset($_POST['EmployeeID'])) {
    $stmt = $conn->prepare("UPDATE employees SET FirstName = ?, LastName = ?, BirthDate = ?, Roles = ? WHERE EmployeeID = ?");
    $stmt->execute([
        $_POST['FirstName'],
        $_POST['LastName'],
        $_POST['BirthDate'],
        $_POST['Roles'],
        $_POST['EmployeeID']
    ]);
    echo "OK";
}
?>