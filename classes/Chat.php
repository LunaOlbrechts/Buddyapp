<?php

include_once(__DIR__ . "/Db.php");

class Chat
{
    private $message;
    private $sender;
    private $recieverName;
    private $recieverId;


    public static function sendMessage(Chat $message)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_chat (sender, recieverName, recieverId, message) VALUES (:sender, :recieverName, :recieverId, :message)");
        $sender = $message->getSender();
        $recieverName = $message->getRecieverName();
        $recieverId = $message->getRecieverId();
        $message = $message->getMessage();
        

        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":recieverName", $recieverName);
        $statement->bindValue(":recieverId", $recieverId);
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
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set the value of sender
     *
     * @return  self
     */ 
    public function setSender($sender)
    {
        $this->sender = $sender;

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
}
