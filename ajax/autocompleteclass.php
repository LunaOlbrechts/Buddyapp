<?php
    include_once(__DIR__ . "/../classes/UserManager.php");
    include_once(__DIR__ . "/../classes/Db.php");

    if(!empty($_GET)){
        $input = $_GET['searchField'];

        UserManager::autocompleteClass($searchClass);

        $resp_body = $result ? [$result] : [];
        $response = [
            'status' => 'succes',
            'body' => htmlspecialchars($input)
        ];

       header('Content-Type: application/json');
       echo json_encode($response);

    }


?>