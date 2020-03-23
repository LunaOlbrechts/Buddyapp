<?php

include_once(__DIR__ . "/Db.php");


class User{
    private $firstName;
    private $lastName;
    private $email;
    private $password;


    /*
        Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /*
        Set the value of email
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function save(){
        // connection
        $conn = Db::getConnection();

        // CHECK IF EMAIL IS TAKEN
        if (isset($_POST['email'])) {
            $email = $this->getEmail();
            $conn = Db::getConnection();
            $sql = "SELECT * FROM tl_user WHERE email='$email'";
            $results = $conn->query($sql);
    	    if ($results->rowCount() > 0) {
  	            echo "taken";	
    	    }else{
  	            echo "not_taken";
  	        }
  	        exit();

        }         

    
        // insert query
        $statement = $conn->prepare("INSERT INTO tl_user (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password) ");
        
        
        $firstname = $this->getFirstName();
        $lastname = $this->getLastName();
        $email = $this->getEmail();
        $password = $this->getPassword();
    
        
        $statement->bindValue(":firstName", $firstname);
        $statement->bindValue(":lastName", $lastname);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", $password);
    
        $result = $statement->execute();
    
        // return result
        return $result;
    
    }

    
}