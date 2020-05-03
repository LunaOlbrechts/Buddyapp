<?php
spl_autoload_register();

use \src\BeMyBuddy\UserManager;

if (!empty($_POST)) {

    $input = $_POST['text'];

    $result = UserManager::autocompleteSearchName($input);

    $resp_body = $result ? [$result] : [];
    $response = [
        'status' => "succes",
        'body' => $resp_body
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
