<?php

// Load in the database and user class

require 'classes/Database.php';
require 'classes/User.php';

// Establish the database connection

$db = new Database();
$conn = $db->getConn();

$user = new User();

// The values sent through the FormData object are accessible via POST variables
// Tie the POST values to the new instance of the user class

$user->firstname = $_POST['firstname'];
$user->lastname = $_POST['lastname'];
$user->email = $_POST['email'];
$user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if an email address is already tied to an account in the database

if ($user->username_check($conn, $user->email)) {
  echo 'An account for this email address already exists.';
  return;
}

// Create a new user account

if ($user->create($conn)) {
  echo 'Your user account has been created successfully. Please <a href="login.html"><span id="login-link">log in here</span></a>.';
  return;
}

// Otherwise, return an error message

echo "An error has occurred.";
