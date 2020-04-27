<?php

include_once(__DIR__ . "../../classes/Db.php");

class Buddies
{
    private $sender;
    private $reciever;
    private $denyMessage;


    // DO THE REQUEST   
    public static function sendRequest(Buddies $buddy) 
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO buddie_request (sender, reciever) VALUES (:sender, :reciever)");
        $sender = $buddy->getSender();
        $reciever = $buddy->getReciever();        
        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":reciever", $reciever);
        // $result = $statement->execute();

        if ($statement->execute()) {
            throw new Exception("Buddy Request send!");
        }

        return $statement;        
    }

    public static function findRequest() 
    {
        $conn = Db::getConnection();
        // SENDER -> RECEIVER ( EVEN VOOR TESTEN)
        $statement = $conn->prepare("SELECT * from tl_user INNER JOIN buddie_request ON tl_user.id = buddie_request.sender WHERE reciever= '" . $_SESSION['user_id'] . "'");
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
    public static function makeBuddy()
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


    // REFUSE BUDDY
    public static function denyNoMessage()
    {
        $conn = Db::getConnection();
        $sender = $_SESSION['user_id'];
        $reciever = $_SESSION['requested'];
        $statement = $conn->prepare("INSERT INTO buddie_denied (sender, reciever, message) VALUES ($sender, $reciever, NULL)");

        if($statement->execute()){
            $deleteStatement = $conn->prepare("DELETE FROM buddie_request WHERE reciever= '" . $_SESSION['user_id'] . "'");
            $deleteStatement->execute();
        }
    }

    public static function denyMessage($messageForDeny)
    {
        $conn = Db::getConnection();
        $sender = $_SESSION['user_id'];
        $reciever = $_SESSION['requested'];
        $denyMessage = $messageForDeny->getDenyMessage();
        $statement = $conn->prepare("INSERT INTO buddie_denied (sender, reciever, message) VALUES ($sender, $reciever, $denyMessage)");

        if($statement->execute()){
            $deleteStatement = $conn->prepare("DELETE FROM buddie_request WHERE reciever= '" . $_SESSION['user_id'] . "'");
            $deleteStatement->execute();
        }
    }

    public static function checkDenyMessage()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from buddie_denied WHERE reciever= '" . $_SESSION['user_id'] . "'");
        $statement->execute();

        if($statement->rowCount() > 0)
        {
            return true;

        }
        else { 
          return false;
        }
    }

    public static function printDenyMessage()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from buddie_denied WHERE reciever= '" . $_SESSION['user_id'] . "'");
        $statement->execute();
        $denied = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $denied;
    }

    public static function deleteMessage()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("DELETE FROM buddie_denied WHERE reciever= '" . $_SESSION['user_id'] . "'");
        $statement->execute();
    }


    // DISPLAY BUDDY
    public static function haveBuddy($id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from tl_buddies WHERE user_one = $id OR user_two = $id");
        $statement->execute();

        
        if($statement->rowCount() == 0)
        {
            return 0;

        }
        else { 
          return 1;
        }
    }

    // IF Buddy request send don't show button
    public static function haveRequestOrBuddy($id, $otherId)
    {
        $conn = Db::getConnection();
        $statement1 = $conn->prepare("SELECT * from tl_buddies WHERE user_one = $id OR user_two = $id");
        $statement1->execute();

        $statement2 = $conn->prepare("SELECT * from buddie_request WHERE sender = $id OR reciever = $id");
        $statement2->execute();

        $statement3 = $conn->prepare("SELECT * from buddie_request WHERE sender = $otherId OR reciever = $otherId");
        $statement3->execute();

        $statement4 = $conn->prepare("SELECT * from tl_buddies WHERE user_one = $otherId OR user_two = $otherId");
        $statement4->execute();

        if($statement1->rowCount() > 0)
        {
            return 1;
        }
        elseif ($statement2->rowCount() > 0)
        {
            return 1;
        }
        elseif ($statement3->rowCount() > 0)
        {
            return 1;
        }
        elseif ($statement4->rowCount() > 0)
        {
            return 1;
        }
        else 
        { 
          return 0;
        }
    }


    public static function displayBuddy($id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from tl_buddies WHERE user_one = $id");
        $statement->execute();

        if($statement->rowcount() == 0) 
        {
            $user2Statement = $conn->prepare("SELECT * FROM tl_user INNER JOIN tl_buddies ON tl_user.id =  tl_buddies.user_one WHERE user_two = $id");
            $user2Statement->execute();
            $currentuser = $user2Statement->fetchAll(PDO::FETCH_ASSOC);
            return $currentuser;
        } else 
        {
            $user1Statement = $conn->prepare("SELECT * FROM tl_user INNER JOIN tl_buddies ON tl_user.id =  tl_buddies.user_two WHERE user_one = $id");
            $user1Statement->execute();
            $currentuser = $user1Statement->fetchAll(PDO::FETCH_ASSOC);
            return $currentuser;
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

    /**
     * Get the value of denyMessage
     */ 
    public function getDenyMessage()
    {
        return $this->denyMessage;
    }

    /**
     * Set the value of denyMessage
     *
     * @return  self
     */ 
    public function setDenyMessage($denyMessage)
    {
        $this->denyMessage = $denyMessage;

        return $this;
    }
}



?>
