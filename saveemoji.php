<?php 

spl_autoload_register();

if(!empty($_POST)){
    $e = new \src\BeMyBuddy\Emoji();
    $e->setMessageId($_POST['id']);
    $e->setEmoji($_POST['emoji']);

    $e->save();

    $response = [
        'status' => 'success',
        'body' => 'test',
        'message' => 'Emoji saved'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
