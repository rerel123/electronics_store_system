<?php
include '../includes/db.php';

if (isset($_POST['CustomerID'])) {
    try {
        $sql = "INSERT INTO orders (CustomerID, EmployeeID, OrderDate, ShipperID) 
                VALUES (:CustomerID, :EmployeeID, :OrderDate, :ShipperID)";
                
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':CustomerID' => $_POST['CustomerID'],
            ':EmployeeID' => $_POST['EmployeeID'],
            ':OrderDate'  => $_POST['OrderDate'],
            ':ShipperID'  => $_POST['ShipperID']
        ]);
        echo "Success";
    } catch (PDOException $e) {
        echo "Insert Failed: " . $e->getMessage();
    }
}
?>