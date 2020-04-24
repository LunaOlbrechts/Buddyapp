<?php

include_once(__DIR__ . "/../classes/Chat.php");

session_start();

if(!empty($_POST)){

    $message = new Chat();
    $message->setMessage($_POST['chat_message']);
    $message->setSenderId($_SESSION['user_id']);
    $message->setSenderName($_SESSION['first_name']);
    $message->setReceiverId($_SESSION['reciever_id']);
    $message->setReceiverName($_SESSION['reciever_name']);

    Chat::sendMessage($message);

    $response = [
        'status' => 'success',
        'body' => htmlspecialchars($_POST['chat_message']),
        'message' => 'Saved message to database'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

?>