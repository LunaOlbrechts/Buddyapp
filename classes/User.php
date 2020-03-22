<?php 

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
        $conn = new PDO('mysql:host=localhost;dbname=buddy_app', "root", "root");
    
        // insert query
        $statement = $conn->prepare("insert into tl_users (firstname, lastname, email, password) values (:firstname, :lastname, :email, :password" );
        
        
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