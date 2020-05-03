<?php
   
include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Db.php");

if (!empty($_POST)){
    
    $searchClass = $_POST['text'];

    $result = SearchClass::autocompleteClass($searchClass);

    $resp_body = $result ? [$result] : [];
    $response = [
        'status' => "succes",
        'body' => $resp_body
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

}
