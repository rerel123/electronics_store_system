<?php
include '../includes/db.php';

if (isset($_POST['OrderID'])) {
    try {
        $sql = "UPDATE orders 
                SET CustomerID = :CustomerID, 
                    EmployeeID = :EmployeeID, 
                    OrderDate  = :OrderDate, 
                    ShipperID  = :ShipperID 
                WHERE OrderID  = :OrderID";
                
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':CustomerID' => $_POST['CustomerID'],
            ':EmployeeID' => $_POST['EmployeeID'],
            ':OrderDate'  => $_POST['OrderDate'],
            ':ShipperID'  => $_POST['ShipperID'],
            ':OrderID'    => $_POST['OrderID']
        ]);
        echo "Success";
    } catch (PDOException $e) {
        // Gi-check kung foreign key constraint error ba (Error code 23000)
        if ($e->getCode() == '23000') {
            echo "Dili ma-save! Ang Customer ID, Employee ID, o Shipper ID nga imong gibutang wala nag-exist sa database system.";
        } else {
            echo "Update Failed: " . $e->getMessage();
        }
    }
}
?>