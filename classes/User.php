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
        $password = password_hash($this->getPassword(), PASSWORD_BCRYPT, ['cost' => 12]);
        $this->password = $password;

        return $this;
    }

    public function save(){
        // connection
        session_start();
        $errors = [];
        $conn = Db::getConnection();

        // check if nothing is empty

        if (isset($_POST['signup-btn'])) {
            if (empty($_POST['firstname'])) {
                $errors['firstname'] = 'firstname required';
            }
            if (empty($_POST['lastname'])) {
                $errors['lastname'] = 'lastname required';
            }
            if (empty($_POST['email'])) {
                $errors['email'] = 'Email required';
            }
            if (empty($_POST['password'])) {
                $errors['password'] = 'Password required';
            }
            

          

           // CHECK IF EMAIL IS TAKEN
           if (isset($_POST['email'])) {
            $email = $this->getEmail();
            $conn = Db::getConnection();
            $sql = "SELECT * FROM tl_user WHERE email='$email'";
            $results = $conn->query($sql);
            if ($results->rowCount() > 0) {
                $errors['email'] = "Email already exists";
                  echo "taken";	
            }
        }

    
        // insert query
        if (count($errors) === 0) {

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

}
    

// return result
// return $result;

}
   
    }

}