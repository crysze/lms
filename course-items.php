<?php session_start();
require 'classes/Database.php';
require 'classes/Course.php';

$db = new Database();
$conn = $db->getConn();

// Get the course from the database via the corresponding get parameter

$course = Course::getByID($conn, $_GET['id']);

// Get the current course progress from the database for this specific user and this specific course

$enrolment = Course::getProgress($conn, $_SESSION['user_id'], $_GET['id']);

// Multiply the number from the database (with two decimal places) with 100

$progress = $enrolment['progress'] * 100;

$videos = Course::getAllVideos($conn, $_GET['id']);

$question = Course::getQuizQuestion($conn, $_GET['id']);
$answers = Course::getQuizAnswers($conn, $_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/course-items.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <script src="js/course-items.js" defer></script>
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
          <span id="course-completion">Course completion: <span id="course-completion-pc"><?= htmlspecialchars($progress) . "%"; ?></span></span>
          <div id="progress-bar">
            <div id="progress-bar-filled" progress="<?= /* Assign the progress to a new custom HTML attribute for usage in course-items.js */ htmlspecialchars($progress); ?>"></div>
          </div>
        </div>
        <div id="course-items-ctn">
          <?php
          $i = 0;
          foreach ($videos as $video) {
          $i++; ?>
          <div class="course-item video">
            <i class="fas fa-play"></i>
            <span class="course-item-title"><?= $i . ". " . htmlspecialchars($video['title']) ?></span>
          </div>
          <?php } ?>
          <div class="course-item quiz">
            <i class="fas fa-question-circle"></i>
            <span class="course-item-title" hierarchy="<?= htmlspecialchars(++$i); ?>"><?= $i . "."?> Quiz</span>
          </div>
        </div>
      </div>
      <div id="content">
        <a href="index.php">
          <div id="go-back-ctn">
            <span id="go-back-txt">Go back</span>
            <i class="fas fa-times fa-2x"></i>
          </div>
        </a>
        <div id="video-ctn">
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
              <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?= htmlspecialchars($video['yt_id']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          <?php } ?>
          <div id="video-nav-ctn">
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
          </div>
          <div id="item-completion-ctn">
            <button class="btn-red"><a href="logout.php">Complete Item</a></button>
          </div>
        </div>
        <div class="content-sub-ctn" hidden>
          <div id="quiz-ctn">
            <div id="quiz-hdg">
              <span id="quiz-content">3. Quiz</span>
              <span id="quiz-qu-nr">Question <span class="quiz-qu-nr-hi">1</span> of <span class="quiz-qu-nr-hi">1</span></span>
            </div>
            <div id="quiz">
              <span id="quiz-question"><?= htmlspecialchars($question); ?></span>
              <?php foreach ($answers as $answer) { ?>
                <div class="question-item">
                  <br>
                  <input type="checkbox" class="qu-checkbox" id="<?= htmlspecialchars($answer['choice']); ?>"><label for="<?= htmlspecialchars($answer['choice']); ?>"><?= htmlspecialchars($answer['choice']); ?>) <?= htmlspecialchars($answer['text']); ?></label>
                  <br>
                </div>
              <?php } ?>
            </div>
            <div id="btn-ctn">
              <button id="question-complete-btn">Submit Answer</button>
            </div>
          </div>
        </div>
      </div>
    </main>


  </body>
</html>
