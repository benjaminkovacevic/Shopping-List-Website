<?php
    // Start or resume the session
    session_start();

    // Establishing database connection
    require_once 'components/db_connect.php';
    
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    // Handle the form submission for adding a new item
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_item_button'])) {
            $newItemName = $_POST['item_name'];
            $shoppingListId = $_POST['shopping_list_id'];
    
            // Insert the new item into the database
            $insertStatement = $pdo->prepare("INSERT INTO items (name, shopping_list_id) VALUES (:name, :shopping_list_id)");
            $insertStatement->bindParam(':name', $newItemName);
            $insertStatement->bindParam(':shopping_list_id', $shoppingListId);
            $insertStatement->execute();
    
            // Redirect back to the current page to avoid form resubmission
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Handle the form submission for deleting an item from shopping list
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['item_id']) && isset($_POST['delete_button'])) {
            $itemId = $_POST['item_id'];
    
            // Implement your deletion logic here, for example, execute a DELETE query
            $deleteStatement = $pdo->prepare("DELETE FROM items WHERE id = :item_id");
            $deleteStatement->bindParam(':item_id', $itemId);
            $deleteStatement->execute();
    
            // Redirect back to the same page after deletion
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Handle the form submission for creating a new shopping list
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['create_list_button'])) {
            $listName = $_POST['list_name'];
            $categoryId = $_POST['category_id'];
            $userId = $_SESSION['user_id'];

            // Insert the new shopping list into the database
            $insertStatement = $pdo->prepare("INSERT INTO shopping_lists (name, category_id, user_id) VALUES (:name, :category_id, :user_id)");
            $insertStatement->bindParam(':name', $listName);
            $insertStatement->bindParam(':category_id', $categoryId);
            $insertStatement->bindParam(':user_id', $userId);
            $insertStatement->execute();

            // Redirect back to the current page to avoid form resubmission
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Handle the form submission for deleting a shopping list
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_list_button'])) {
            $listId = $_POST['list_id'];

            // Delete the associated items first
            $deleteItemsStatement = $pdo->prepare("DELETE FROM items WHERE shopping_list_id = :listId");
            $deleteItemsStatement->bindParam(':listId', $listId);
            $deleteItemsStatement->execute();

            // Perform the deletion of the shopping list
            $deleteListStatement = $pdo->prepare("DELETE FROM shopping_lists WHERE id = :listId");
            $deleteListStatement->bindParam(':listId', $listId);
            $deleteListStatement->execute();

            // Redirect to the current page after deletion
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Handle the form submission for marking the list as finished
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['finish_list_button'])) {
            $listId = $_POST['list_id'];

            // Update the status of the shopping list to 2
            $updateListStatement = $pdo->prepare("UPDATE shopping_lists SET status = '1' WHERE id = :listId");
            $updateListStatement->bindParam(':listId', $listId);
            $updateListStatement->execute();

            // Redirect to the current page after updating the status
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
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
    </head>

    <body>
        <?php require 'components/header.php'; ?> <!-- Include the header -->
        <div class="container-fluid">
            <div class="row">
                <?php require 'components/sidebar.php'; ?> <!-- Include the sidebar -->
                <div class="col-10 pt-4">
                    <!-- Page content goes here -->

                    <div class="row">

                        <!-- New shopping list -->
                        <div class="col-md-3 col-6">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white"><b>Create New Shopping List</b></div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label for="list_name">List Name</label>
                                            <input type="text" class="form-control" id="list_name" name="list_name" placeholder="Enter list name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">Category</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                <?php
                                                $categoryStatement = $pdo->prepare("SELECT id, name FROM categories");
                                                $categoryStatement->execute();
                                                $categories = $categoryStatement->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($categories as $category) {
                                                    $categoryId = $category['id'];
                                                    $categoryName = $category['name'];
                                                    echo '<option value="' . $categoryId . '">' . $categoryName . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="create_list_button">Create List</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Retrieve all shopping lists and create cards -->
                        <?php
                        
                        $user_id = $_SESSION['user_id'];

                        $statement = $pdo->prepare("SELECT * FROM shopping_lists WHERE user_id = :user_id AND status = '0';");
                        $statement->bindParam(':user_id', $user_id);
                        $statement->execute();
                        $shoppingLists = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($shoppingLists as $list) {
                            $listId = $list['id'];
                            $listName = $list['name'];

                            // Retrieve category name for the current shopping list
                            $categoryStatement = $pdo->prepare("SELECT name FROM categories WHERE id = :category_id");
                            $categoryStatement->bindParam(':category_id', $list['category_id']);
                            $categoryStatement->execute();
                            $categoryName = $categoryStatement->fetchColumn();

                            // Retrieve items for the current shopping list
                            $statement = $pdo->prepare("SELECT * FROM items WHERE shopping_list_id = :listId");
                            $statement->bindValue(':listId', $listId);
                            $statement->execute();
                            $items = $statement->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <div class="col-md-3 col-6">
                                <div class="card mb-3">
                                    <div class="card-header bg-secondary text-white">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <b><?php echo $listName . ' (' . $categoryName . ')'; ?></b>
                                            </div>
                                            <div class="col-auto">
                                                <form class="delete-list-form" method="POST" action="">
                                                    <input type="hidden" name="list_id" value="<?php echo $listId; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger delete-button" name="delete_list_button">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="col-auto">
                                                <form class="finish-list-form" method="POST" action="">
                                                    <input type="hidden" name="list_id" value="<?php echo $listId; ?>">
                                                    <button type="submit" class="btn btn-sm btn-success finish-button" name="finish_list_button">
                                                        Mark list as Finished
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <ul class="list-group">
                                        <?php foreach ($items as $item) {
                                            $itemId = $item['id'];
                                            $itemName = $item['name'];
                                            $checked = $item['checked']; // Retrieve the checked status

                                            ?>

                                            <li class="list-group-item d-flex justify-content-between">
                                                <div class="form-check">
                                                    <?php
                                                        echo '<input class="form-check-input" type="checkbox" id="item' . $itemId . '"';
                                                        echo ($checked) ? ' checked' : ''; // Set the "checked" attribute if the item is checked
                                                        echo '>';
                                                    ?>
                                                    <?php echo '<label class="form-check-label" for="item' . $itemId . '">' . $itemName . '</label>'; ?>
                                                </div>
                                                <form class="delete-item-form" method="POST" action="">
                                                    <?php echo '<input type="hidden" name="item_id" value="' . $itemId . '">'; ?>
                                                    <button type="submit" class="btn btn-sm btn-warning delete-button" name="delete_button"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </li>

                                        <?php } ?>

                                        </ul>

                                        <form class="mt-3" method="POST" action="">
                                            <div class="form-row">
                                                <div class="col-8">
                                                    <?php echo '<input type="text" class="form-control" name="item_name" placeholder="New item">'; ?>
                                                    <?php echo '<input type="hidden" name="shopping_list_id" value="' . $listId . '">'; ?>
                                                </div>
                                                <div class="col-4">
                                                    <?php echo '<button type="submit" name="add_item_button" class="btn btn-primary">Add Item</button>'; ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>

        <script src="components/js/checkbox_listener.js">
            // This script listens for checkbox changes and updates the database accordingly via AJAX.
        </script>
    </body>
</html>
