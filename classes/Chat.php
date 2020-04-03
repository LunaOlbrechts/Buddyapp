<?php

include_once(__DIR__ . "/classes/Db.php");

class Chat
{
    private $message;
    private $name;

    public static function sendMessage(Chat $message)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_chat (name, message) VALUES (:name, :message) ");

        $name = $message->getName();
        $message = $message->getMessage();

        $statement->bindValue(":name", $name);
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
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
