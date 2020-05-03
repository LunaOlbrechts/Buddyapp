<?php 

use \src\BeMyBuddy\Emoji;

spl_autoload_register();

    if(!empty($_POST)){
        $e = new Emoji();
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
