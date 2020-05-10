<?php

include_once(__DIR__ . "/../classes/Forum.php");

session_start();

if (!empty($_POST)) {
    $userId = $_SESSION["user_id"];
    $id = $_POST["id"];
    Forum::downVote($id);
    Forum::removeVote($id, $userId);

    $response = [
        'status' => 'success',
        'body' => htmlspecialchars($_POST["id"]),
        'message' => 'Vote -1'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
