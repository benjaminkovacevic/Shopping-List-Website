<?php
    session_start();

    // Check if the "user_id" session variable is set (User is logged in)
    if (!isset($_SESSION['user_id'])) {
        // Redirect to home page
        header('Location: index.php'); 
        exit();
    }

    // Establishing database connection
    require_once 'components/db_connect.php';

    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    // Retrieve user details from the database
    $user_id = $_SESSION['user_id'];
    $query = "SELECT id, first_name, last_name, phone_number, address, email FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Perform validation and update the user details in the database

        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $password = $_POST['password'];

        $errors = array();

        // Validate first name
        if (empty($first_name)) {
            $errors[] = "First name is required";
        }

        // Validate last name
        if (empty($last_name)) {
            $errors[] = "Last name is required";
        }

        // Validate phone number
        if (empty($phone_number)) {
            $errors[] = "Phone number is required";
        } elseif (!preg_match('/^\d{10}$/', $phone_number)) {
            $errors[] = "Invalid phone number format. Please enter a 10-digit number";
        }

        // Validate address
        if (empty($address)) {
            $errors[] = "Address is required";
        }

        // Validate email
        if (empty($email)) {
            $errors[] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        // Validate password
        if (empty($password)) {
            $errors[] = "Password is required";
        } elseif (strlen($password) < 8) {
            $errors[] = "Password should be at least 8 characters long";
        }

        // If there are no errors, update the user details in the database
        if (empty($errors)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $query = "UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name, phone_number = :phone_number, address = :address, password = :password WHERE id = :user_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':first_name', $first_name);
            $stmt->bindValue(':last_name', $last_name);
            $stmt->bindValue(':phone_number', $phone_number);
            $stmt->bindValue(':address', $address);
            $stmt->bindValue(':password', $hashed_password);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();

            // Redirect to the profile page to display the updated information
            header('Location: profile.php');
            exit();
        }
    }

    
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            <div class="col-3 pt-4 mx-auto">
                <!-- Page content goes here -->
                <div class="card p-4">
                    <div class="card-header">
                        <h3>Edit Account Details</h3>
                    </div>
                    <div class="card-body">
                        <!-- Show the errors -->
                        <?php
                            if (isset($errors) && is_array($errors) && count($errors) > 0) {
                                echo '<div class="alert alert-danger">';
                                foreach ($errors as $error) {
                                    echo $error . '<br>';
                                }
                                echo '</div>';
                            }
                        ?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number:</label>
                                <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['address']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
