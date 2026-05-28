<?php
include '../includes/db.php';

if (isset($_POST['CategoryID'], $_POST['CategoryName'])) {
    $sql = "UPDATE categories SET 
                CategoryName = :CategoryName, 
                Description  = :Description 
            WHERE CategoryID = :CategoryID";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':CategoryName' => $_POST['CategoryName'],
        ':Description'  => $_POST['Description'],
        ':CategoryID'   => $_POST['CategoryID']
    ]);

    echo "OK";
}
?>