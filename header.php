<?php
if (isset($_SESSION['username'])) {
  echo "
  <div class='dropdown'>
    <i class='fas fa-user'></i>
    <span class='header-item-dropdown'><a href='profile.php'>{$_SESSION['username']}</a></span>
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
      <i class='fas fa-user'></i>
      <span class='header-item'><a href='user-login.php'>Login / Register</a></span>
    </div>
    ";
}
?>
