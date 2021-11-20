<?php session_start();
require 'classes/Database.php';
require 'classes/Course.php';

// This checks, if a quiz had already been completed before, which the correct answer is on order to highlight it with a green background

$db = new Database();
$conn = $db->getConn();

$answerValidation = Course::validateAnswer($conn, $_GET['answer_id']);

if (!$answerValidation) {
 echo 'Failed';
 return;
}

echo 'Passed';
