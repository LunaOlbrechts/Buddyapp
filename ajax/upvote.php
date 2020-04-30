<?php

include_once(__DIR__ . "/../classes/Db.php");

session_start();

if(!empty($_POST)){
    
    $conn = Db::getConnection();
    $statement = $conn->prepare("UPDATE tl_forum_comment set votes = votes + 1 WHERE id = :id");

    $statement->bindValue(":id", $_POST["id"]);

    $result = $statement->execute();

    $response = [
        'status' => 'success',
        'body' => htmlspecialchars($_POST["id"]),
        'message' => 'Vote +1'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
