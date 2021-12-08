<?php session_start();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

  require '../classes/Database.php';
  require '../classes/Course.php';

  $db = new Database();
  $conn = $db->getConn();

  $completion = Course::setCompletion($conn, $_SESSION['user_id'], $_GET['course_id'], $_GET['item_id']);
  $progress = Course::updateProgress($conn, $_SESSION['user_id'], $_GET['course_id'], $_GET['new_progress']);

  if ($completion && $progress) {
    http_response_code(201);
    echo 'Completed';
    return;
  }

  http_response_code(500);
  echo 'Server error';


} else {
  header("Location: ../index.php", TRUE, 301);
  exit();
}
