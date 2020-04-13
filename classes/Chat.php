<?php

include_once(__DIR__ . "../../classes/Db.php");

class Chat
{
    private $message;
    private $sender;
    private $reciever;

    public static function sendMessage(Chat $message)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_chat (sender, reciever, message) VALUES (:sender, :reciever, :message)");
        $sender = $message->getSender();
        $reciever = $message->getReciever();
        $message = $message->getMessage();
        

        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":reciever", $reciever);
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
    public function getReciever()
    {
        return $this->reciever;
    }

    /**
     * Set the value of reciever
     *
     * @return  self
     */ 
    public function setReciever($reciever)
    {
        $this->reciever = $reciever;

        return $this;
    }
}
