<?php session_start();
require 'classes/Database.php';
require 'classes/Course.php';

$db = new Database();
$conn = $db->getConn();

$enrolment = Course::enroll_user($conn, $_SESSION['user_id'], $_GET['id']);

if ($enrolment) {
  echo 'Enter';
  return;
}

echo 'Enrolment failed';

