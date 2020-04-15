<?php

include_once(__DIR__ . "../../classes/Db.php");

class Buddies
{
    private $sender;
    private $reciever;


    // DO THE REQUEST   
    public static function sendRequest(Buddies $buddy) 
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO buddie_request (sender, reciever) VALUES (:sender, :reciever)");
        $sender = $buddy->getSender();
        $reciever = $buddy->getReciever();        
        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":reciever", $reciever);
        
        $result = $statement->execute();
        return $result;        
    }

    public static function findRequest() 
    {
        $conn = Db::getConnection();
        // SENDER -> RECEIVER ( EVEN VOOR TESTEN)
        $statement = $conn->prepare("SELECT * from buddie_request WHERE reciever= '" . $_SESSION['user_id'] . "'");
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
        $statement = $conn->prepare("SELECT * from buddie_request WHERE reciever= '" . $_SESSION['user_id'] . "'");
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
    public function makeBuddy()
    {
        $conn = Db::getConnection();
        $deleteStatement = $conn->prepare("DELETE FROM buddie_request WHERE reciever= '" . $_SESSION['user_id'] . "'");
        $deleteStatement->execute();

        if($deleteStatement->execute()){
            $sender = $_SESSION['user_id'];
            $reciever = $_SESSION['requested'];
            $statement = $conn->prepare("INSERT INTO tl_buddies (user_one, user_two) VALUES ($sender, $reciever)");
            $statement->execute();
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



?>
