<header>
  <!-- Header content goes here -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php"><b>Shopping list</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <?php
            if(isset($_SESSION['first_name'])) {
              echo '<a class="nav-link text-warning" href="#"><i class="fas fa-user"></i> <b>' . $_SESSION['first_name'] . '</b></a>';
            } else {
              echo '<a class="nav-link text-white" href="login.php"><b>Login / Register</b></a>';
            }
          ?>
        </li>
      </ul>
    </div>
  </nav>
</header>
