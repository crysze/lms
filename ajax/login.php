<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    // Load in the database and user class

    require '../classes/Database.php';
    require '../classes/User.php';
    require '../classes/Auth.php';

    // Initiate the session

    session_start();

    // Establish the database connection

    $db = new Database();
    $conn = $db->getConn();

    // Check if the email address and password match - if they do, log the user in

    if (User::authentication($conn, $_POST['email'], $_POST['password']) && User::is_user_active($conn, $_POST['email'])) {
        Auth::login();
        $_SESSION['username'] = User::get_username($conn, $_POST['email']);
        $_SESSION['user_id'] = User::get_user_id($conn, $_POST['email']);
        http_response_code(202);
        echo "You've logged in successfully. Redirecting...";
        return;
    } else if (!User::is_user_active($conn, $_POST['email'])) {
        http_response_code(403);
        echo "This email address hasn't been registered or verified yet.";
        return;
    }

    // If they don't match, display an error message

    http_response_code(400);
    echo 'Login incorrect';
    return;

} else {
    header("Location: ../index.php", TRUE, 301);
    exit();
  }

