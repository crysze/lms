<?php session_start();
require 'classes/Database.php';
require 'classes/Course.php';

$db = new Database();
$conn = $db->getConn();

$course = Course::getByID($conn, $_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/single-course.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <script src="js/enroll.js" defer></script>
    <title><?= htmlspecialchars($course->title) ?></title>
  </head>
  <body>
    <header>
      <div id="header">
        <i class="fas fa-home"></i>
        <span class="header-item"><a href="index.php">Home</a></span>
      <?php require 'header.php' ?>
      </div>
      <hr>
      <div class="space"></div>
    </header>
    <main>
      <div id="course-desc-ctn">
        <img id="course-img" src="<?= htmlspecialchars($course->img) ?>">
        <h1><?= htmlspecialchars($course->title) ?></h1>
        <span id="course-desc-txt">
          <?= htmlspecialchars($course->description) ?>
        <p id="post-enroll" hidden>Congrats! You've been enrolled successfully!</p>
        </span>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
                if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] && !Course::enrolment_check($conn, $_SESSION['user_id'], $_GET['id'])) {
                  echo "<button id='enroll-btn' class='btn-red'>Enroll</button>";
                } elseif (Course::enrolment_check($conn, $_SESSION['user_id'], $_GET['id'])) {
              echo "<button id='enroll-btn' class='btn-red'>Enter</button>";
            }
           } else {
                echo "<span id='login-prompt'>
                  <i class='fas fa-exclamation-circle fa-2x'></i>
                  Please <a href='user-login.php'><span id='login-link'>log in</span></a> to enroll in this course
                </span>";
            } ?>
      </div>
    </main>
  </body>
</html>
