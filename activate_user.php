<?php
    // Establishing database connection
    require_once 'components/db_connect.php';

    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    // Retrieve activation code from URL parameter
    $activationCode = $_GET['code'];

    try {
        // Check if the activation code exists in the database
        $sql = "SELECT * FROM users WHERE activation_code = :activationCode";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':activationCode', $activationCode);
        $stmt->execute();

        // If a matching code is found, activate the user
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $userId = $row['id'];
            $sql = "UPDATE users SET activated = '1' WHERE id = :userId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            // Display a success message
            header("Location: login.php?activated=1");
        } else {
            // Display an error message
            echo "Invalid activation code!";
        }
    } catch (PDOException $e) {
        // Display an error message if there's an exception
        echo "Error: " . $e->getMessage();
    }
?>
