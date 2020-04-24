<?php

include_once(__DIR__ . "../../classes/Db.php");
include_once(__DIR__ . "/Db.php");

class Chat
{
    private $message;
    private $senderId;
    private $senderName;
    private $recieverId;
    private $recieverName;


    public static function sendMessage(Chat $message)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_chat (senderId, receiverId, senderName, receiverName, message) VALUES (:senderId, :recieverId, :senderName, :recieverName, :message)");
        $senderId = $message->getSenderId();
        $recieverId = $message->getRecieverId();
        $senderName = $message->getSenderName();
        $recieverName = $message->getRecieverName();
        $message = $message->getMessage();
        
        $statement->bindValue(":senderId", $senderId);
        $statement->bindValue(":recieverId", $recieverId);
        $statement->bindValue(":senderName", $senderName);
        $statement->bindValue(":recieverName", $recieverName);
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
     * Get the value of reciever
     */ 
    public function getRecieverName()
    {
        return $this->recieverName;
    }

    /**
     * Set the value of reciever
     *
     * @return  self
     */ 
    public function setRecieverName($recieverName)
    {
        $this->recieverName = $recieverName;

        return $this;
    }

    /**
     * Get the value of recieverId
     */ 
    public function getRecieverId()
    {
        return $this->recieverId;
    }

    /**
     * Set the value of recieverId
     *
     * @return  self
     */ 
    public function setRecieverId($recieverId)
    {
        $this->recieverId = $recieverId;

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
