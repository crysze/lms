<?php

// Check if the request to the server came from Ajax - if it doesn't, redirect to 404 to prevent direct access to the PHP file

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

    // Load in the database

    require '../classes/Database.php';

    // Establish the database connection

    $db = new Database();
    $conn = $db->getConn();

    // Database query to get all current tags

    $sql = 'SELECT tag_title
            FROM tag';

    $stmt = $conn->prepare($sql);


    if ($stmt->execute()) {

        // http_response_code(202) etc. are left out, as with the fetch API - as opposed to XMLHttpRequest - a response code can't be returned to the js file on top of the JSON

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = json_encode(array_column($rows, 'tag_title'));
        echo $response;
        return;
    }
} else {
    header("Location: ../index.php", TRUE, 301);
    exit();
  }

