<?php

include_once(__DIR__ . "../../classes/Db.php");
include_once(__DIR__ . "/Db.php");

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

    /**
     * Get the value of sender
     */ 
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * Set the value of sender
     *
     * @return  self
     */ 
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;

        return $this;
    }

    /**
     * Get the value of receiver
     */ 
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * Set the value of receiver
     *
     * @return  self
     */ 
    public function setReceiverName($receiverName)
    {
        $this->receiverName = $receiverName;

        return $this;
    }

    /**
     * Get the value of receiverId
     */ 
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * Set the value of receiverId
     *
     * @return  self
     */ 
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
