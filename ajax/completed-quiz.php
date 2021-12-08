<?php session_start();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

  require '../classes/Database.php';
  require '../classes/Course.php';

  // This checks, if a quiz had already been completed before, which the correct answer is on order to highlight it with a green background

  $db = new Database();
  $conn = $db->getConn();

  $answerValidation = Course::validateAnswer($conn, $_GET['answer_id']);

  if (!$answerValidation) {
    http_response_code(400);
    echo 'Failed';
    return;
  }

  http_response_code(202);
  echo 'Passed';

} else {
  header("Location: ../index.php", TRUE, 301);
  exit();
}
