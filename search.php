<?php session_start();
require 'classes/Database.php';
require 'classes/Course.php';

$db = new Database();
$conn = $db->getConn();

// Get all courses that feature the user's input in the course description

if ($_GET['q'] && isset($_GET['q'])) {
  $searchResults = Course::userSearch($conn, $_GET['q']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/cl-fav.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <script src="js/index.js" defer></script>
    <title>Search Results</title>
  </head>
  <body>
    <header>
      <div id="header">
        <a class="header-link" href="index.php">
          <i class="fas fa-home"></i>
          <span class="header-item">Home</span>
        </a>
      <?php require 'header.php' ?>
      </div>
      <hr>
      <div class="space"></div>
    </header>
    <main>
      <span id="search-results">Search results for:</span> <h2><?= $_GET['q']; ?></h2>
      <div class="slider">
        <i class="fas fa-caret-left fa-5x"></i>
        <div class="widget-ctn">
          <div class="widget-sub-ctn">
            <?php foreach ($searchResults as $searchResult) {
              // $searchResult has to be converted into an array (from a class object) to be able to loop over it
              $searchResult = (array) $searchResult; ?>
              <a href="course.php?id=<?= htmlspecialchars($searchResult['id']); ?>">
                <div class="widget">
                  <div class="widget-logo">
                    <img class="php-img" src="<?= htmlspecialchars($searchResult['path']); ?>">
                  </div>
                  <div class="widget-title">
                    <?= htmlspecialchars($searchResult['title']); ?>
                  </div>
                </div>
              </a>
            <?php } ?>
            </div>
        </div>
        <i class="fas fa-caret-right fa-5x"></i>
      </div>
    </main>
