<?php
require 'classes/Auth.php';
session_start();
Auth::logout();
?>
<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/cl-fav.png">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/logout.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <script src="js/index.js" defer></script>
    <title>Code Source</title>
  </head>
  <body>
    <header>
      <div id="header">
        <div id='header'>
          <a class="header-link" href='user-login.php'>
            <i class='fas fa-user'></i>
            <span class='header-item'>Login / Register</span>
          </a>
          </div>
        </a>
      </div>
      <hr>
    </header>
    <main>
      <div id="logout">You've logged out successfully. Thanks for your visit!</span>
    </main>
  </body>
</html>
