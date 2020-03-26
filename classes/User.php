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
        if(empty($_POST['email'])){
            throw new Exception("E-mail cannot be empty");
        }
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
        if(empty($_POST['firstname'])){
            throw new Exception("Firstname cannot be empty");
        }
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
        if(empty($_POST['lastname'])){
            throw new Exception("Lastname cannot be empty");
        }
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
        if(empty($_POST['password'])){
            throw new Exception("Password cannot be empty");
        }
        if (isset($_POST['password']) && $_POST['password'] !== $_POST['passwordconf']) {
           throw new Exception("The two passwords do not match");
        }
        $password = password_hash($this->getPassword(), PASSWORD_BCRYPT, ['cost' => 12]);
        $this->password = $password;

        return $this;
    }

    public function save(){
        // connection
        session_start();
        $conn = Db::getConnection();

        // check if nothing is empty

        if (isset($_POST['signup-btn'])) {
     

           // CHECK IF EMAIL IS TAKEN
           if (isset($_POST['email'])) {
            $email = $this->getEmail();
            $conn = Db::getConnection();
            $sql = "SELECT * FROM tl_user WHERE email='$email'";
            $results = $conn->query($sql);
            if ($results->rowCount() > 0) {
                throw new Exception("Email is already used");
                  echo "taken";	
            }
        }

        // CHECK IF USERNAME IS @student.thomasmore.be
        $domainWhiteList = ['student.thomasmore.be'];
        $domain = array_pop(explode('@', $email));

        if(!in_array($domain, $domainWhiteList)) {
            throw new Exception("Username should end with @student.thomasmore.be");
        }

    
        // insert query

        $firstname = $this->getFirstName();
        $lastname = $this->getLastName();
        $email = $this->getEmail();
        $password = $this->getPassword();

        $statement = $conn->prepare("INSERT INTO tl_user (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password) ");
                   
            
        $statement->bindValue(":firstName", $firstname);
        $statement->bindValue(":lastName", $lastname);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", $password);
    
        $result = $statement->execute();
        echo "saved to database";
    

// return result
return $result;

}
   
    }

}