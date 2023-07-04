<?php
    // Establishing database connection
    require_once '../db_connect.php';

    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $itemId = $_POST['item_id'];
        $checked = $_POST['checked'];

        // Update the item in the database
        // Convert checked value from 0 to 1 and vice versa
        $newChecked = $checked == 1 ? 0 : 1;

        $updateStatement = $pdo->prepare("UPDATE items SET checked = :checked WHERE id = :item_id");
        $updateStatement->bindParam(':checked', $newChecked, PDO::PARAM_BOOL);
        $updateStatement->bindParam(':item_id', $itemId, PDO::PARAM_INT);
        $updateStatement->execute();
    }
?>
