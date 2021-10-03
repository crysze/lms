<?php session_start();

if (!$_SESSION['is_logged_in']) {
  header("Location: user-login.php", TRUE, 301);
  exit();
  // see if you can implement a redirect message with JS via status code 301
}

require 'classes/Database.php';
require 'classes/Course.php';

$db = new Database();
$conn = $db->getConn();

$enrolments = Course::allEnrolments($conn, $_SESSION['user_id']);
$enrolmentCount = count($enrolments, COUNT_NORMAL);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/profile.css">
  <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
  <title>Profile</title>
</head>
<body>
  <header>
    <div id="header">
      <i class="fas fa-home"></i>
      <span class="header-item"><a href="index.php">Home</a></span>
    </div>
    <hr>
  </header>
  <main>
    <div id="sidebar-left">
      <div id="sidebar-nav">
        <i class="fas fa-user fa-7x"></i>
        <br>
        <span id="username"><?= $_SESSION['username']; ?></span>
        <hr id="hr-sidebar">
        <span id="courses">Courses</span>
        <button class="btn-active">In Progress</button>
        <button class="btn-inactive">Completed</button>
        <button class="btn-red"><a href="logout.php">Logout</a></button>
      </div>
    </div>
    <div id="table">
      <table>
        <th>Course</th>
        <th>Enrolment</th>
        <th>Progress</th>
        <?php foreach ($enrolments as $enrolment) { ?>
          <tr>
            <td><a href="./course.php?id=<?= $enrolment['id'] ?>"><?= $enrolment['title']; ?></a></td>
            <td><?= $enrolment['date']; ?></td>
            <td><?= ($enrolment['progress'] * 100); ?>%</td>
          </tr>
        <?php } ?>
      </table>
      <span id="total-courses">You are currently enrolled in <span id="course-number"><?= $enrolmentCount; ?></span> course(s)</span>
    </div>
  </main>

</body>
</html>
