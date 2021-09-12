<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/register-login.css">
    <script src="https://kit.fontawesome.com/5782589434.js" crossorigin="anonymous"></script>
    <script src="js/login.js" defer></script>
    <title>Login</title>
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
      <h1>Log in</h1>
      <br>
      <form method="POST">
        <div id="form-ctn">
          <div class="form-item">
            <label for="email">Email</label>
            <input id="email" name="email" type="text">
            <br>
          </div>
          <div class="form-item">
            <label for="password">Password</label>
            <input id="password" name="password" type="password">
            <br>
          </div>
        </div>
        <div id="submit-btn-ctn">
          <input id="submit" type="submit" value="Submit">
        </div>
        <div id="reg-link">
          <span id="first-time">First-time visitor?</span>
          <span id="reg-here"><a href="user-register.php">Register here</a></span>
        </div>
        <div id="missing-fields-ctn">
          <div id="missing-fields">
            <i class="fas fa-exclamation-circle fa-2x"></i>
            <span id="missing-fields-txt">Please fill in the missing fields</span>
          </div>
        </div>
        <div id="password-wrong-ctn">
          <div id="password-wrong">
            <i class="fas fa-exclamation-circle fa-2x"></i>
            <span id="missing-fields-txt">Passwords don't match</span>
          </div>
        </div>
        <div id="email-taken-ctn">
          <div id="email-taken">
            <i class="fas fa-exclamation-circle fa-2x"></i>
            <span id="email-taken-txt"></span>
          </div>
        </div>
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
