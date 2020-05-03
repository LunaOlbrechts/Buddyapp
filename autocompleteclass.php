<?php
   
use \src\BeMyBuddy\SearchClass;

spl_autoload_register();

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
