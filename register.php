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
  
   // Establishing SMTP connection
  require_once 'components/sendmail.php';

  // Checking if the request is sent via POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Checking if all fields are filled
    if (!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
      $firstName = $_POST["firstName"];
      $lastName = $_POST["lastName"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $phoneNumber = $_POST["phoneNumber"];
      $address = $_POST["address"];

      // Checking if a user with the same email already exists in the database
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        // User with the same email already exists, display appropriate error message
        echo '<script>alert("User with the same email already exists!")</script>';
      } else {

        // generate activation code
        $length = 64;
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[mt_rand(0, $max)];
        }

        // send email
        sendMail($email, $firstName, 'Shopping List - Email Verification', 'Please use this link to activate your account: https://danijela.stud.vts.su.ac.rs/activate_user.php?code='.$code);

        // Inserting the new user into the database
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, phone_number, address, email, password, activation_code) 
        VALUES (:first_name, :last_name, :phoneNumber, :address, :email, :password, :activation_code)");
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':activation_code', $code); 
        $stmt->execute();

        // Redirecting to the login page
        header("Location: login.php");
        exit();
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
    <title>Registration</title>
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
          <h2 class="card-title text-center">Sign Up</h2>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
              <label for="firstName">First Name:</label>
              <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name">
            </div>
            <div class="form-group">
              <label for="lastName">Last Name:</label>
              <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name">
            </div>
            <div class="form-group">
              <label for="lastName">Phone number:</label>
              <input type="text" class="form-control" id="lastName" name="phoneNumber" placeholder="Enter your phone number">
            </div>
            <div class="form-group">
              <label for="lastName">Address:</label>
              <input type="text" class="form-control" id="lastName" name="address" placeholder="Enter your address">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </form>
          <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php">Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

