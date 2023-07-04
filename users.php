<?php
    session_start();

    // Check if the "admin" session variable is set to 1
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        // Redirect to home page
        header('Location: index.php'); 
        exit();
    }

    // Establishing database connection
    require_once 'components/db_connect.php';

    $database = new DatabaseConnection();
    $pdo = $database->getConnection();
    
    // Get all users from the database
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle ban/unban form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ban_unban'])) {
        $userId = $_POST['user_id'];
    
        // Retrieve the current banned status of the user
        $stmt = $pdo->prepare("SELECT banned FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch();
        
        if ($user) {
            $banned = $user['banned'];
            
            // Update the banned status of the user
            $newBanned = $banned == 1 ? 0 : 1;
            $stmt = $pdo->prepare("UPDATE users SET banned = :banned WHERE id = :id");
            $stmt->execute(['banned' => $newBanned, 'id' => $userId]);
            
            // Redirect to the same page to refresh
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Users</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <!-- custom css -->
        <link rel="stylesheet" type="text/css" href="components/css/main.css">
    </head>

    <body>
        <?php require 'components/header.php'; ?> <!-- Include the header -->
        <div class="container-fluid">
            <div class="row">
                <?php require 'components/sidebar.php'; ?> <!-- Include the sidebar -->
                <div class="col-10 pt-4">
                    <div class="card p-4">
                        <h5 class="card-header">Users</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Banned</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user) {
                                            echo "<tr>";
                                            echo "<td>" . $user['id'] . "</td>";
                                            echo "<td>" . $user['first_name'] . "</td>";
                                            echo "<td>" . $user['last_name'] . "</td>";
                                            echo "<td>" . $user['phone_number'] . "</td>";
                                            echo "<td>" . $user['address'] . "</td>";
                                            echo "<td>" . $user['email'] . "</td>";
                                            echo "<td>" . ($user['banned'] == 1 ? 'Yes' : 'No') . "</td>";
                                            echo "<td>";
                                            echo "<form method='POST' action=''>";
                                            echo "<input type='hidden' name='user_id' value='" . $user['id'] . "'>";
                                            echo "<button type='submit' name='ban_unban' class='btn btn-sm " . ($user['banned'] == 1 ? 'btn-success' : 'btn-danger') . "'>";
                                            echo ($user['banned'] == 1 ? 'Unban' : 'Ban');
                                            echo "</button>";
                                            echo "</form>";
                                            echo "</td>";
                                            echo "</tr>";
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

