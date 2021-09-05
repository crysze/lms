<?php

// Load in the database and user class

require 'classes/Database.php';
require 'classes/User.php';
require 'classes/Auth.php';

// Initiate the session

session_start(['cookie_secure' => true,'cookie_httponly' => true]); // Why not put this inside the if statement?

// Establish the database connection

$db = new Database();
$conn = $db->getConn();

// Check if the email address and password match

if (User::authentication($conn, $_POST['email'], $_POST['password'])) {
    Auth::login();
    echo "You've logged in successfully. Redirecting...";
    return;
}

// If they don't match, display an error message

echo 'Login incorrect';

