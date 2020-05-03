<?php

spl_autoload_register();

if (!empty($_POST)) {

    $input = $_POST['text'];

    $result = \src\BeMyBuddy\SearchBuddy::autocompleteSearchName($input);

    $resp_body = $result ? [$result] : [];
    $response = [
        'status' => "succes",
        'body' => $resp_body
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
