<?php
    // Start or resume the session
    session_start();

    // Establishing database connection
    require_once 'components/db_connect.php';

    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    // Query to retrieve category information with the corresponding count
    $query = "SELECT categories.name, COUNT(*) as count
    FROM shopping_lists
    INNER JOIN categories ON shopping_lists.category_id = categories.id
    GROUP BY categories.name";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalCount = array_sum(array_column($categories, 'count'));

    foreach ($categories as &$category) {
        $category['percentage'] = ($category['count'] / $totalCount) * 100;
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Electronic shopping list</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
         <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <!-- custom css -->
        <link rel="stylesheet" type="text/css" href="components/css/main.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body>
        <?php require 'components/header.php'; ?> <!-- Include the header -->
        <div class="container-fluid">
            <div class="row">
                <?php require 'components/sidebar.php'; ?> <!-- Include the sidebar -->
                <div class="col-10">
                    <!-- Page content goes here -->
                    <div class="row justify-content-center">
                        <div class="col-4 text-center">
                            <h3><b>Statistics</b></h3>
                            <p>This chart represents the percentage of created shopping lists in different categories.</p>
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            // Retrieve the category data from PHP
            var categoryData = <?php echo json_encode($categories); ?>;
        
            // Extract the category names and percentages
            var categoryNames = categoryData.map(function (category) {
                return category.name;
            });
        
            var categoryPercentages = categoryData.map(function (category) {
                return category.percentage;
            });

            // Create the chart using Chart.js
            var ctx = document.getElementById('categoryChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: categoryNames,
                    datasets: [{
                        data: categoryPercentages,
                        backgroundColor: [
                            '#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0', '#9966ff' // You can add more colors if needed
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: '#333'
                        }
                    }
                }
            });
        </script>

    </body>
</html>
