<?php

session_start();

// Redirect the user to index.php if they are already logged in

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
  header("Location: index.php", TRUE, 301);
  exit();
}

?>

<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/register-login.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <script src="js/register.js" defer></script>
    <title>Register</title>
  </head>
  <body>
    <header>
      <div id="header">
        <a class="header-link" href="index.php">
          <i class="fas fa-home"></i>
          <span class="header-item">Home</a></span>
        </a>
      </div>
      <hr>
    </header>
    <main>
      <h1>Register</h1>
      <br>
      <form method="POST">
        <div id="form-ctn">
          <div class="form-item">
            <label for="firstname">First Name<span class="asterisk">*</span></label>
            <input id="firstname" name="firstname" type="text">
            <br>
          </div>
          <div class="form-item">
            <label for="lastname">Last Name<span class="asterisk">*</span></label>
            <input id="lastname" name="lastname" type="text">
            <br>
          </div>
          <div class="form-item">
            <label for="email">Email<span class="asterisk">*</span></label>
            <input id="email" name="email" type="text">
            <br>
          </div>
          <div class="form-item">
            <label for="password">Password<span class="asterisk">*</span></label>
            <input id="password" name="password" type="password">
            <br>
          </div>
          <div class="form-item">
            <label for="confirm-password">Confirm Password<span class="asterisk">*</span></label>
            <input id="confirm-password" name="confirm-password" type="password">
            <br>
          </div>
        </div>
        <div id="submit-btn-ctn">
          <input id="submit" type="submit" value="Submit">
        </div>
        <div id="mandatory-fields">
          <span id="mandatory-fields-txt"><span class="asterisk">*</span> Mandatory fields</span>
        </div>
        <div class="loader"></div>
        <div id="response-ctn">
          <div id="response">
            <i class="fas fa-exclamation-circle fa-2x"></i>
            <span id="response-txt"></span>
          </div>
        </div>
      </form>
    </main>
    </body>
</html>
