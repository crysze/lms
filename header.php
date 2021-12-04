<?php
if (isset($_SESSION['username'])) {
  echo "
  <div class='dropdown'>
    <a class='header-link' href='profile.php'>
      <i class='fas fa-user'></i>
      <span class='header-item-dropdown'>{$_SESSION['username']}</span>
    </a>
    <div class='dropdown-content'>
      <a href='profile.php'>User Profile</a>
      <hr id='hr-dropdown'>
      <a href='logout.php'>Logout</a>
    </div>
  </div>
  ";
  } else {
    echo "
      <div id='header'>
        <a class='header-link' href='user-login.php'>
          <i class='fas fa-user'></i>
          <span class='header-item'>Login / Register</span>
        </a>
      </div>
    ";
}
?>
