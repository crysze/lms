<?php

session_start();

// Redirect the user to index.php if they are already logged in

if (!$_SESSION['is_logged_in']) {
  header("Location: index.php", TRUE, 301);
  exit();
}

require 'classes/Database.php';
require 'classes/Course.php';

$db = new Database();
$conn = $db->getConn();

// Get the course from the database via the corresponding get parameter

$course = Course::getByID($conn, $_GET['id']);

// Get the current course progress from the database for this specific user and this specific course

$enrolment = Course::getProgress($conn, $_SESSION['user_id'], $_GET['id']);

// Multiply the number from the database (with two decimal places) with 100

$progress = (int)$enrolment['progress'];

$videos = Course::getAllVideos($conn, $_GET['id']);

$question = Course::getQuizQuestion($conn, $_GET['id']);
$answers = Course::getQuizAnswers($conn, $_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/cl-fav.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/course-items.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <script src="js/course-items.js" defer></script>
    <script src="js/completion.js" defer></script>
    <script src="js/completion-quiz.js" defer></script>
    <title><?= htmlspecialchars($course->title); ?></title>
  </head>
  <body>
    <main>
      <div id="nav-left">
        <div id="course-title-ctn">
          <i class="fas fa-graduation-cap fa-2x"></i>
          <span id="course-title"><?= htmlspecialchars($course->title); ?></span>
        </div>
        <div id="course-completion-ctn">
          <span id="course-completion" progress="<?= htmlspecialchars($progress); ?>">Course completion: <span id="course-completion-pc"><?= htmlspecialchars($progress) . "%"; ?></span></span>
          <div id="progress-bar">
            <div id="progress-bar-filled" progress="<?= /* Assign the progress to a new custom HTML attribute for usage in course-items.js */ htmlspecialchars($progress); ?>"></div>
          </div>
        </div>
        <div id="course-items-ctn">
          <?php
          $i = 0;
          foreach ($videos as $video) {
          $i++; ?>
          <div class="course-item video" hierarchy="<?= $i; ?>">
            <i class="fas fa-play"></i>
            <span class="course-item-title"><?= $i . ". " . htmlspecialchars($video['title']) ?></span>
            <?php if ($complete = Course::getCompletion($conn, $_GET['id'], $_SESSION['user_id'], $i)) {
              echo '<i class="fas fa-check-circle"></i>';
            } ?>
          </div>
          <?php } ?>
          <div class="course-item quiz" hierarchy="<?= htmlspecialchars(++$i); ?>">
            <i class="fas fa-question-circle"></i>
            <span class="course-item-title" hierarchy="<?= htmlspecialchars($i); ?>"><?= $i . "."?> Quiz</span>
            <?php if ($complete = Course::getCompletion($conn, $_GET['id'], $_SESSION['user_id'], $i)) {
              echo '<i class="fas fa-check-circle"></i>';
            } ?>
          </div>
        </div>
      </div>
      <div id="content">
          <div id="go-back-ctn">
            <a class="header-link" href="index.php">
              <span id="go-back-txt">Go back</span>
              <i class="fas fa-times fa-2x"></i>
            </a>
          </div>
        <div class="video-ctn">
        <?php
        $i = 0;
        foreach ($videos as $video) {
          $i++; ?>
            <div class="content-sub-ctn" <?php if ($i > 1) { echo "hidden"; } ?>>
              <span id="video-content">
                <span id="video-order">
                  <?= htmlspecialchars($video['hierarchy']); ?>
                </span>.
                <span id="video-title">
                  <?= htmlspecialchars($video['title']); ?>
                </span>
              </span>
                <div class="video-ctn">
                  <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?= htmlspecialchars($video['yt_id']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
              <div id="item-completion-ctn">
                <button class="btn-red <?php if ($complete = Course::getCompletion($conn, $_GET['id'], $_SESSION['user_id'], $i)) {
                  echo 'completed'; } ?>" hierarchy="<?= $i;?>"><?php if ($complete) { echo 'Completed'; } else { echo 'Complete Item'; } ?></button>
              </div>
              <div class="loader"></div>
            </div>
          <?php } ?>
          <!-- <div id="video-nav-ctn">
            <a href="#">
              <div id="previous-ctn">
                <i class="fas fa-chevron-left fa-2x"></i>
                <span id="previous">Previous</span>
              </div>
            </a>
            <a href="#">
              <div id="next-ctn">
                <span id="next">Next</span>
                <i class="fas fa-chevron-right fa-2x"></i>
              </div>
            </a>
          </div> -->
        </div>
        <div class="content-sub-ctn" hidden>
          <div id="quiz-ctn">
            <!-- <div id="quiz-hdg">
              <span id="quiz-content">3. Quiz</span>
              <span id="quiz-qu-nr">Question <span class="quiz-qu-nr-hi">1</span> of <span class="quiz-qu-nr-hi">1</span></span>
            </div> -->
            <div id="quiz">
              <span id="quiz-question"><?= htmlspecialchars($question); ?></span>
              <?php foreach ($answers as $answer) { ?>
                <div class="question-item">
                  <br>
                  <input type="radio" name="selection" class="qu-checkbox" value="<?= htmlspecialchars($answer['id']); ?>"><label for="<?= htmlspecialchars($answer['choice']); ?>" value="<?= htmlspecialchars($answer['id']); ?>"><?= htmlspecialchars($answer['choice']); ?>) <?= htmlspecialchars($answer['text']); ?></label>
                  <br>
                </div>
              <?php } ?>
            </div>
            <div id="btn-ctn">
              <button class="question-complete-btn <?php if ($complete = Course::getCompletion($conn, $_GET['id'], $_SESSION['user_id'], ++$i)) {
                  echo 'completed'; } ?>" hierarchy="<?= $i;?>"><?php if ($complete) { echo 'Completed'; } else { echo 'Submit Answer'; } ?></button>
            </div>
            <div class="loader-quiz"></div>
          </div>
        </div>
      </div>
    </main>
    <div id="overlay" hidden>
      <div id="message-box">
        <span id="quiz-msg"></span>
        <button id="quiz-continue">Continue</button>
    </div>
  </body>
</html>
