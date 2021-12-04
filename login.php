<?php

// Load in the database and user class

require 'classes/Database.php';
require 'classes/User.php';
require 'classes/Auth.php';

// Initiate the session

session_start(); // Why not put this inside the if statement?

// Establish the database connection

$db = new Database();
$conn = $db->getConn();

// Check if the email address and password match

if (User::authentication($conn, $_POST['email'], $_POST['password'])) {
    Auth::login();
    $_SESSION['username'] = User::get_username($conn, $_POST['email']);
    $_SESSION['user_id'] = User::get_user_id($conn, $_POST['email']);
    http_response_code(201);
    echo "You've logged in successfully. Redirecting...";
    return;
}

// If they don't match, display an error message

echo 'Login incorrect';

