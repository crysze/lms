<?php session_start();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

  require '../classes/Database.php';
  require '../classes/Course.php';

  $db = new Database();
  $conn = $db->getConn();

  $enrolment = Course::enroll_user($conn, $_SESSION['user_id'], $_GET['id']);

  if ($enrolment) {
    http_response_code(201);
    echo 'Enter';
    return;
  }
  http_response_code(500);
  echo 'Enrolment failed';

} else {
  header("Location: ../index.php", TRUE, 301);
  exit();
}

