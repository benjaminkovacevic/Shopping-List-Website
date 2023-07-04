<?php
  // Start or resume the session
  session_start();

  // Check if the 'user_id' session variable is set (already logged in)
  if (isset($_SESSION['user_id'])) {
    // Redirect the user to index.php
    header("Location: index.php");
    // Stop further script execution
    exit();
  }
  
  // Establishing database connection
  require_once 'components/db_connect.php';

  $database = new DatabaseConnection();
  $pdo = $database->getConnection();

  // Checking if the request is sent via POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Checking if all fields are filled
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
      $email = $_POST["email"];
      $password = $_POST["password"];
  
      // Checking if a user with the given email exists in the database
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();
  
      if ($stmt->rowCount() > 0) {
        // User with the given email exists, verify the password and activation status
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashedPassword = $user['password'];
        $activated = $user['activated'];
  
        if (password_verify($password, $hashedPassword)) {
          if ($activated == 1) {
            // Password is correct and account is activated, start a new session and redirect to the dashboard
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['admin'] = $user['admin'];
            $_SESSION['banned'] = $user['banned'];
  
            // Checking if user is banned
            if ($_SESSION['banned'] == 1) {
              echo '<script>alert("Sorry, you are banned from logging in to this website.")</script>';
  
              // Unset all session variables
              $_SESSION = array();
              // Destroy the session
              session_destroy();
            } else {
              header("Location: index.php");
              exit();
            }
          } else {
            // Account is not activated
            echo '<script>alert("Please check your email and verify your account before logging in.")</script>';
          }
        } else {
          // Password is incorrect, display appropriate error message
          echo '<script>alert("Invalid email or password!")</script>';
        }
      } else {
        // User with the given email doesn't exist, display appropriate error message
        echo '<script>alert("Invalid email or password!")</script>';
      }
    } else {
      // Some fields are not filled, display appropriate error message
      echo '<script>alert("Please fill in all the fields!")</script>';
    }
  }
?>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="components/css/login-register.css">
  </head>

  <body>
    <?php require 'components/header.php'; ?> <!-- Include the header -->
    <div class="container">
      <div class="card col-md-6">
        <div class="card-body">
          <?php
            if (isset($_GET['activated']) && $_GET['activated'] == 1) {
              echo '<div class="alert alert-success" role="alert">Email activated. You can now log in.</div>';
            }          
          ?>
          <h2 class="card-title text-center">Login</h2>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </form>
          <div class="text-center mt-3">
            <p>Don't have an account? <a href="register.php">Sign up</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

