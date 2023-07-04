<?php
    echo '
      <div class="col-2 sidebar">
        <!-- Sidebar content goes here -->
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shopping-list.php"><i class="fas fa-list"></i> My Shopping List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="finished-lists.php"><i class="fas fa-check"></i> Finished Lists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="statistics.php"><i class="fas fa-chart-bar"></i> Statistics</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="profile.php"><i class="fas fa-user"></i> Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
    ';
            // Display administrator pages only to administrators
            if ($_SESSION['admin'] == 1) {
              echo '<li class="nav-divider"></li>';
              echo '<li class="nav-title"><b>ADMINISTRATOR</b></li>';
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="users.php"><i class="fas fa-user-shield"></i> Users</a>';
              echo '</li>';
            }
    echo '
        </ul>
      </div>
    ';
?>
