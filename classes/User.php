<?php 

class User{
    private $firstName;
    private $lastName;
    private $email;


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
}