<?php session_start();

if (!$_SESSION['is_logged_in']) {
  header("Location: user-login.php", TRUE, 301);
  exit();
  // see if you can implement a redirect message with JS via status code 301
}
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
        <tr>
          <td>PHP Fundamentals</td>
          <td>05-Feb-2021</td>
          <td>40%</td>
        </tr>
        <tr>
          <td>JS Fundamentals</td>
          <td>12-Mar-2021</td>
          <td>60%</td>
        </tr>
        <tr>
          <td>JS OOP</td>
          <td>16-Jun-2021</td>
          <td>40%</td>
        </tr>
        <tr>
          <td>MySQL Fundamentals</td>
          <td>23-Jul-2021</td>
          <td>40%</td>
        </tr>
      </table>
      <span id="total-courses">You are currently enrolled in <span id="course-number">4</span> courses</span>
    </div>
  </main>

</body>
</html>
