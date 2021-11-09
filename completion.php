<?php session_start();
require 'classes/Database.php';
require 'classes/Course.php';

$db = new Database();
$conn = $db->getConn();

$completion = Course::setCompletion($conn, $_SESSION['user_id'], $_GET['course_id'], $_GET['item_id']);
$progress = Course::updateProgress($conn, $_SESSION['user_id'], $_GET['course_id'], $_GET['new_progress']);

if ($completion && $progress) {
  echo 'Completed';
  return;
}

echo 'Server error';
