<?php
  // Start or resume the session
  session_start();
  
  // Establishing database connection
  require_once 'components/db_connect.php';
  
  $database = new DatabaseConnection();
  $pdo = $database->getConnection();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Shopping List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="components/css/main.css">
</head>

<body>
    <?php require 'components/header.php'; ?> <!-- Include the header -->
    <div class="container-fluid">
        <div class="row">
            <?php 
                if (isset($_SESSION['user_id'])) { // Include the sidebar only to logged in users
                    require 'components/sidebar.php'; 
                    $colClass = 'col-10';
                } else {
                    $colClass = 'col-12';
                }
            ?>
            <div class="<?php echo $colClass; ?>">
                <!-- Page content goes here -->
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            
                            <!-- Additional Information -->
                            <div class="card mt-4">
                                <div class="card-body bg-secondary text-light">
                                    <h5 class="card-title"><b>About our website</b></h5>
                                    <p class="card-text">Welcome to our electronic shopping list website! We aim to provide you with a convenient and organized way to create and manage your shopping lists. Our user-friendly interface allows you to easily add, remove, and mark items as purchased. You can also customize your shopping list by categorizing items. Stay organized and never forget anything you need with our shopping list solution.</p>
                                </div>
                            </div>

                            <h1 class="text-center mb-4 pt-4"><b>Frequently Asked Questions</b></h1>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">What is a shopping list?</h5>
                                    <p class="card-text">A shopping list is a list of items that you plan to buy during a shopping trip. It helps you stay organized and ensures you don't forget anything you need.</p>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title">How can I create a shopping list?</h5>
                                    <p class="card-text">You can create a shopping list by adding items you want to buy to the list. You can organize the list by categories or prioritize items based on your preferences.</p>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title">How can I manage my shopping list?</h5>
                                    <p class="card-text">You can manage your shopping list by adding or removing items, marking items as purchased, and organizing the list as per your preferences. Many shopping list apps also provide features like setting reminders and creating multiple lists..</p>
                                </div>
                            </div>

                            <!-- Alert -->
                            <div class="alert alert-info mt-4" role="alert">
                                Need assistance? Contact our support team at support@example.com.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
