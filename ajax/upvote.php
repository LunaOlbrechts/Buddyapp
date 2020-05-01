<?php

include_once(__DIR__ . "/../classes/Db.php");
include_once(__DIR__ . "/../classes/Forum.php");

session_start();

if(!empty($_POST)){
    
    $id = $_POST["id"];
    Forum::upvote($id);

    $response = [
        'status' => 'success',
        'body' => htmlspecialchars($_POST["id"]),
        'message' => 'Vote +1'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
