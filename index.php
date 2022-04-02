<?php session_start();
require 'classes/Database.php';
require 'classes/Course.php';

$db = new Database();
$conn = $db->getConn();

// Fetch the courses by category from the database

$PHPCourses = Course::getByCategory($conn, 'PHP / MySQL');
$JSCourses = Course::getByCategory($conn, 'JavaScript');

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
        <?php require 'header.php';?>
        </div>
        <hr>
        <div class="space"></div>
      </header>
    </div>
        <div id="logo">
          <img src="img/cl3_06-12.svg">
        </div>
    <main>
      <div id="search">
        <input type="text" placeholder="Search for content...">
        <i class="fa-solid fa-magnifying-glass"></i>
      </div>
      <div id="search-suggestions">
        <div id="suggestions-ctn">
          <span id="suggestions-title">Suggestions</span>
        </div>
      </div>
      <h2>PHP / MySQL</h2>
      <div class="slider">
        <i class="fas fa-caret-left fa-5x"></i>
        <div class="widget-ctn">
          <div class="widget-sub-ctn">
            <?php foreach ($PHPCourses as $PHPCourse) { ?>
              <a href="course.php?id=<?= htmlspecialchars($PHPCourse['id']); ?>">
                <div class="widget">
                  <div class="widget-logo">
                    <img class="php-img" src="<?= htmlspecialchars($PHPCourse['path']); ?>">
                  </div>
                  <div class="widget-title">
                    <?= htmlspecialchars($PHPCourse['title']); ?>
                  </div>
                </div>
              </a>
            <?php } ?>
            </div>
        </div>
        <i class="fas fa-caret-right fa-5x"></i>
      </div>
      <h2>JavaScript</h2>
      <div class="slider">
        <i class="fas fa-caret-left fa-5x"></i>
        <div class="widget-ctn">
        <div class="widget-sub-ctn">
            <?php foreach ($JSCourses as $JSCourse) { ?>
              <a href="course.php?id=<?= htmlspecialchars($JSCourse['id']); ?>">
                <div class="widget">
                  <div class="widget-logo">
                    <img class="php-img" src="<?= htmlspecialchars($JSCourse['path']); ?>">
                  </div>
                  <div class="widget-title">
                    <?= htmlspecialchars($JSCourse['title']); ?>
                  </div>
                </div>
              </a>
            <?php } ?>
            </div>
        </div>
        <i class="fas fa-caret-right fa-5x"></i>
      </div>
    </main>

  </body>
</html>
