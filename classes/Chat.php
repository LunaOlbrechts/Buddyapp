<?php

include_once(__DIR__ . "../../classes/Db.php");
include_once(__DIR__ . "/Db.php");

// session_start();

class Chat
{
    private $message;
    private $senderId;
    private $senderName;
    private $receiverId;
    private $receiverName;


    public static function sendMessage(Chat $message)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_chat (senderId, receiverId, senderName, receiverName, message) VALUES (:senderId, :receiverId, :senderName, :receiverName, :message)");
        $senderId = $message->getSenderId();
        $receiverId = $message->getReceiverId();
        $senderName = $message->getSenderName();
        $receiverName = $message->getReceiverName();
        $message = $message->getMessage();

        $statement->bindValue(":senderId", $senderId);
        $statement->bindValue(":receiverId", $receiverId);
        $statement->bindValue(":senderName", $senderName);
        $statement->bindValue(":receiverName", $receiverName);
        $statement->bindValue(":message", $message);
        $result = $statement->execute();
        return $result;
    }

    public static function updateMessages($senderId, $receiverId)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM tl_chat WHERE (senderId = '" . $senderId . "' AND receiverId = '" . $receiverId . "') OR (senderId = '" . $receiverId . "' AND receiverId = '" . $senderId . "') ORDER BY created_on ASC");

        $statement->bindValue(":senderId", $senderId);
        $statement->bindValue(":receiverId", $receiverId);

        $statement->execute();
        $messages = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $messages;
    }

    public static function updateReaded($senderId, $receiverId)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("UPDATE tl_chat SET readed = 1 WHERE senderId = $receiverId AND receiverId = $senderId");

        $statement->execute();
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }


    public function getSenderName()
    {
        return $this->senderName;
    }


    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;

        return $this;
    }


    public function getReceiverName()
    {
        return $this->receiverName;
    }


    public function setReceiverName($receiverName)
    {
        $this->receiverName = $receiverName;

        return $this;
    }

    public function getReceiverId()
    {
        return $this->receiverId;
    }


    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;

        return $this;
    }

    /**
     * Get the value of senderId
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * Set the value of senderId
     *
     * @return  self
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;

        return $this;
    }
}
