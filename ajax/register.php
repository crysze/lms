<?php

// Check if the request to the server came from Ajax - if it doesn't, redirect to 404 to prevent direct access to the PHP file

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

  // Load in the database and user class

  require '../classes/Database.php';
  require '../classes/User.php';

  // Establish the database connection

  $db = new Database();
  $conn = $db->getConn();

  $user = new User();

  // The values sent through the FormData object are accessible via POST variables
  // Tie the POST values to the new instance of the user class

  $activation_code = bin2hex(random_bytes(16));

  $user->firstname = $_POST['firstname'];
  $user->lastname = $_POST['lastname'];
  $user->email = $_POST['email'];
  $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $user->activation_code = password_hash($activation_code, PASSWORD_DEFAULT);
  $user->activation_expiry = date('Y-m-d H:i:s', time() + 1 * 24 * 60 * 60);

  // Check if an email address is already tied to an account in the database

  if ($user->username_check($conn, $user->email)) {
    http_response_code(400);
    echo 'An account for this email address already exists.';
    return;
  }

  // Create a new user account

  if ($user->create($conn)) {
    $user->send_activation_email($user->email, $activation_code);
    http_response_code(201);
    echo 'Your user account has been created successfully.<br> Please check your emails to activate your account.';
    return;
  }

  // Otherwise, return an error message
  http_response_code(500);
  echo "An error has occurred.";

} else {
  header("Location: ../index.php", TRUE, 301);
  exit();
}

