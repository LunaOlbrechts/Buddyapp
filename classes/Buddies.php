<?php

include_once(__DIR__ . "../../classes/Db.php");

class Buddies
{
    private $sender;
    private $receiver;


    // DO THE REQUEST   
    public static function sendRequest(Buddies $buddy) 
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO buddie_request (sender, receiver) VALUES (:sender, :receiver)");
        $sender = $buddy->getSender();
        $receiver = $buddy->getReciever();        
        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":receiver", $receiver);
        
        $result = $statement->execute();
        return $result;        
    }

    public static function findRequest() 
    {
        $conn = Db::getConnection();
        // SENDER -> RECEIVER ( EVEN VOOR TESTEN)
        $statement = $conn->prepare("SELECT * from tl_user INNER JOIN buddie_request ON tl_user.id = buddie_request.sender WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $statement->execute();
        $buddies = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($statement->rowCount() > 0)
        {
            return $buddies;
        }
        else { 
          header("Location: index.php");
        }
    }

    public static function findProfile()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from tl_user WHERE id= '" . $_SESSION['receiver_id'] . "'");
        $statement->execute();
        $buddies = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($statement->rowCount() > 0)
        {
            return $buddies;
        }
        else { 
          header("Location: index.php");
        }

    }

    // BUTTON WHEN YOU HAVE A REQUEST
    public static function checkRequest() 
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from buddie_request WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $statement->execute();
        if($statement->rowCount() > 0)
        {
            return true;

        }
        else { 
          return false;
        }
    }
    
    // MAKE THE BUDDY
    public static function makeBuddy()
    {
        $conn = Db::getConnection();
        $deleteStatement = $conn->prepare("DELETE FROM buddie_request WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $deleteStatement->execute();

        if($deleteStatement->execute()){
            $sender = $_SESSION['user_id'];
            $receiver = $_SESSION['requested'];
            $statement = $conn->prepare("INSERT INTO tl_buddies (user_one, user_two) VALUES ($sender, $receiver)");
            $statement->execute();
         } 
    }


    // REFUSE BUDDY
    public static function denyBuddy()
    {
        $conn = Db::getConnection();
        $deleteStatement = $conn->prepare("DELETE FROM buddie_request WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $deleteStatement->execute();

        if($deleteStatement->rowCount() > 0)
        {
            return true;

        }
        else { 
          return false;
        }
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
     * Get the value of receiver
     */ 
    public function getReciever()
    {
        return $this->receiver;
    }

    /**
     * Set the value of receiver
     *
     * @return  self
     */ 
    public function setReciever($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }
}
