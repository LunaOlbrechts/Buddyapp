<?php 

include_once(__DIR__ . "/../classes/UserManager.php");
include_once(__DIR__ . "/../classes/Db.php");

if (!empty($_POST)) {

    $input = $_POST['text'];
    
    $result = UserManager::autocompleteSearchName($input);

    $resp_body = $result ? [$result] : [];
    $response = [
        'status'=> "succes", 
        'body' => $resp_body
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}