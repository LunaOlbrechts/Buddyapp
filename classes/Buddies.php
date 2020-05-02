<?php

include_once(__DIR__ . "../../classes/Db.php");

class Buddies
{
    private $sender;
    private $receiver;
    private $denyMessage;


    // DO THE REQUEST   
    public static function sendRequest(Buddies $buddy)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO buddie_request (sender, receiver) VALUES (:sender, :receiver)");
        $sender = $buddy->getSender();
        $receiver = $buddy->getReceiver();
        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":receiver", $receiver);
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
        $statement = $conn->prepare("SELECT * from tl_user INNER JOIN buddie_request ON tl_user.id = buddie_request.sender WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $statement->execute();
        $buddies = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($statement->rowCount() > 0) {
            return $buddies;
        } else {
            header("Location: index.php");
        }
    }


    // BUTTON WHEN YOU HAVE A REQUEST
    public static function checkRequest()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from buddie_request WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    // MAKE THE BUDDY
    public static function makeBuddy()
    {
        $conn = Db::getConnection();
        $deleteStatement = $conn->prepare("DELETE FROM buddie_request WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $deleteStatement->execute();

        if ($deleteStatement->execute()) {
            $sender = $_SESSION['user_id'];
            $receiver = $_SESSION['requested'];
            $statement = $conn->prepare("INSERT INTO tl_buddies (user_one, user_two) VALUES (:sender, :receiver)");
            $statement->bindValue(":sender", $sender);
            $statement->bindValue(":receiver", $receiver);
            $statement->execute();
        }
    }


    // REFUSE BUDDY
    public static function denyNoMessage($denied)
    {
        $conn = Db::getConnection();
        $sender = $denied->getSender();
        $receiver = $denied->getReceiver();
        $statement = $conn->prepare("INSERT INTO buddie_denied (sender, receiver, message) VALUES (:sender, :receiver, NULL)");
        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":receiver", $receiver);
        

        if ($statement->execute()) {
            $deleteStatement = $conn->prepare("DELETE FROM buddie_request WHERE receiver= '" . $_SESSION['user_id'] . "'");
            $deleteStatement->execute();
        }
    }

    public static function denyMessage($denied)
    {
        $conn = Db::getConnection();
        $sender = $denied->getSender();
        $receiver = $denied->getReceiver();
        $denyMessage = $denied->getDenyMessage();
        $statement = $conn->prepare("INSERT INTO buddie_denied (sender, receiver, message) VALUES (:sender, :receiver, :denyMessage)");
        $statement->bindValue(":sender", $sender);
        $statement->bindValue(":receiver", $receiver);
        $statement->bindValue(":denyMessage", $denyMessage);

        if ($statement->execute()) {
            $deleteStatement = $conn->prepare("DELETE FROM buddie_request WHERE receiver= '" . $_SESSION['user_id'] . "'");
            $deleteStatement->execute();
        }
    }

    public static function checkDenyMessage()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from buddie_denied WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $statement->execute();

        if ($statement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function printDenyMessage()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from buddie_denied WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $statement->execute();
        $denied = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $denied;
    }

    public static function deleteMessage()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("DELETE FROM buddie_denied WHERE receiver= '" . $_SESSION['user_id'] . "'");
        $statement->execute();
    }


    // DISPLAY BUDDY
    public static function haveBuddy($id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from tl_buddies WHERE user_one = $id OR user_two = $id");
        $statement->execute();


        if ($statement->rowCount() == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    // IF Buddy request send don't show button
    public static function haveRequestOrBuddy($id, $otherId)
    {
        $conn = Db::getConnection();
        $statement1 = $conn->prepare("SELECT * from tl_buddies WHERE user_one = $id OR user_two = $id");
        $statement1->execute();

        $statement2 = $conn->prepare("SELECT * from buddie_request WHERE sender = $id OR receiver = $id");
        $statement2->execute();

        $statement3 = $conn->prepare("SELECT * from buddie_request WHERE sender = $otherId OR receiver = $otherId");
        $statement3->execute();

        $statement4 = $conn->prepare("SELECT * from tl_buddies WHERE user_one = $otherId OR user_two = $otherId");
        $statement4->execute();

        if ($statement1->rowCount() > 0) {
            return 1;
        } elseif ($statement2->rowCount() > 0) {
            return 1;
        } elseif ($statement3->rowCount() > 0) {
            return 1;
        } elseif ($statement4->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }


    public static function displayBuddy($id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from tl_buddies WHERE user_one = $id");
        $statement->execute();

        if ($statement->rowcount() == 0) {
            $user2Statement = $conn->prepare("SELECT * FROM tl_user INNER JOIN tl_buddies ON tl_user.id =  tl_buddies.user_one WHERE user_two = $id");
            $user2Statement->execute();
            $currentuser = $user2Statement->fetchAll(PDO::FETCH_ASSOC);
            return $currentuser;
        } else {
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
     * Get the value of receiver
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set the value of receiver
     *
     * @return  self
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

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
