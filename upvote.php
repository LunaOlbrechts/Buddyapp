<?php

use \src\BeMyBuddy\Forum;

spl_autoload_register();
session_start();

if(!empty($_POST)){
    $userId = $_SESSION["user_id"];
    $id = $_POST["id"];
    Forum::upvote($id);
    Forum::addVote($id, $userId);

    $response = [
        'status' => 'success',
        'body' => htmlspecialchars($_POST["id"]),
        'message' => 'Vote +1'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
