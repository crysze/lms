<?php session_start(); ?>
<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/reset.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <title>Code Loop</title>
  </head>
  <body>
    <header>
      <div id="header">
      <?php require 'header.php' ?>
      </div>
      <hr>
      <div class="space"></div>
      <div id="logo">
        <img src="img/logo.png">
      </div>
    </header>
    <main>
      <h2>PHP / MySQL</h2>
      <div class="slider">
        <i class="fas fa-caret-left fa-5x"></i>
        <div class="widget-ctn">
          <a href="course.php?id=1">
            <div class="widget">
              <div class="widget-logo">
                <img class="php-img" src="img/php.png">
              </div>
              <div class="widget-title">
                PHP Fundamentals
              </div>
            </div>
          </a>
        <a href="course.php?id=2">
          <div class="widget">
            <div class="widget-logo">
              <img class="php-img" src="img/php.png">
            </div>
            <div class="widget-title">
              PHP OOP
            </div>
          </div>
        </a>
        <a href="course.php?id=3">
          <div class="widget">
            <div class="widget-logo">
              <img class="mysql-img" src="img/mysql.svg">
            </div>
            <div class="widget-title">
              MySQL Fundamentals
            </div>
          </div>
        </a>
      </div>
        <i class="fas fa-caret-right fa-5x"></i>
      </div>
      <h2>JavaScript</h2>
      <div class="slider">
        <i class="fas fa-caret-left fa-5x"></i>
        <div class="widget-ctn">
          <a href="course.php?id=4">
            <div class="widget">
              <div class="widget-logo">
                <img class="js-img" src="img/js.png">
              </div>
              <div class="widget-title">
                JS Fundamentals
              </div>
            </div>
          </a>
          <a href="course.php?id=5">
            <div class="widget">
              <div class="widget-logo">
                <img class="js-img" src="img/js.png">
              </div>
              <div class="widget-title">
                JS OOP
              </div>
            </div>
          </a>
          <a href="course.php?id=6">
            <div class="widget">
              <div class="widget-logo">
                <img class="njs-img" src="img/node_js.png">
              </div>
              <div class="widget-title">
                Node JS
              </div>
            </div>
          </a>
        </div>
        <i class="fas fa-caret-right fa-5x"></i>
      </div>
    </main>

  </body>
</html>
