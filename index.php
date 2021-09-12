<?php session_start(); ?>
<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/reset.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <title>Code Source</title>
  </head>
  <body>
    <header>
      <div id="header">
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
      </div>
      <hr>
      <div class="space"></div>
      <div id="logo">
        LOGO
      </div>
    </header>
    <main>
      <h2>PHP / MySQL</h2>
      <div class="slider">
        <i class="fas fa-caret-left fa-5x"></i>
        <div class="widget-ctn">
          <a href="course-items-video.html">
            <div class="widget">
              <div class="widget-logo">
                <img class="php-img" src="img/php.png">
              </div>
              <div class="widget-title">
                PHP Fundamentals
              </div>
            </div>
          </a>
          <div class="widget">
            <div class="widget-logo">
              <img class="php-img" src="img/php.png">
            </div>
            <div class="widget-title">
              PHP OOP
            </div>
          </div>
          <div class="widget">
            <div class="widget-logo">
              <img class="mysql-img" src="img/mysql.svg">
            </div>
            <div class="widget-title">
              MySQL Fundamentals
            </div>
          </div>
        </div>
        <i class="fas fa-caret-right fa-5x"></i>
      </div>
      <h2>JavaScript</h2>
      <div class="slider">
        <i class="fas fa-caret-left fa-5x"></i>
        <div class="widget-ctn">
          <div class="widget">
            <div class="widget-logo">
              <img class="js-img" src="img/js.png">
            </div>
            <div class="widget-title">
              JS Fundamentals
            </div>
          </div>
          <div class="widget">
            <div class="widget-logo">
              <img class="js-img" src="img/js.png">
            </div>
            <div class="widget-title">
              JS OOP
            </div>
          </div>
          <div class="widget">
            <div class="widget-logo">
              <img class="njs-img" src="img/node_js.png">
            </div>
            <div class="widget-title">
              Node JS
            </div>
          </div>
        </div>
        <i class="fas fa-caret-right fa-5x"></i>
      </div>
    </main>

  </body>
</html>
