<?php session_start();

require 'classes/Database.php';
require 'classes/User.php';

// Users that are already logged in will be redirected to the index

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
  header("Location: index.php", TRUE, 301);
  exit();
}

$db = new Database();
$conn = $db->getConn();

if (isset($_GET['email']) && isset($_GET['activation_code'])) {
  $user = User::handle_unverified_user($conn, $_GET['activation_code'], $_GET['email']);

  if ($user && !User::is_user_active($conn, $_GET['email']) && User::activate_user($conn, $user['userid'])) {
    $activation_msg = 'Your account has been activated successfully.<br>Please <a href="user-login.php"><span id="login-link">log in here</span></a>.';
  } else if (User::is_user_active($conn, $_GET['email'])) {
    $activation_msg = 'This account has already been activated.<br>Please <a href="user-login.php"><span id="login-link">log in here</span></a>.';
  } else {
    $activation_msg = 'The activation link is not valid, please <a href="user-register.php"><span id="register-link">register</span></a> again.';
  }
} else {
  // If both $_GET parameters are not set, redirect to the index

  header("Location: index.php", TRUE, 301);
  exit();
}


?>

<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/cl-fav.png">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/reset.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <script src="js/index.js" defer></script>
    <title>Code Loop</title>
  </head>
  <body>
    <div id="header-ctn">
        <header>
          <div id="header">
          <?php require 'header.php' ?>
          </div>
          <hr>
          <div class="space"></div>
        </header>
    </div>
    <main>
        <div id="activation-msg"><?= $activation_msg; ?></div>
    </main>
  </body>
</html>
