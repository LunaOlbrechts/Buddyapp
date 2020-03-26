<?php

class User
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $location;
    private $courseInterests;
    private $schoolYear;
    private $sportType;
    private $goingOutType;
    private $description;
    private $profilePicture;
    private $passwordForEmailVerification;


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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

    /**
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */
    public function setLocation($location)
    {
        if(empty($location)){
            $showError = true;
            $message= "Location can't be empty";
            throw new Exception($message);
        }
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of schoolYear
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }

    /**
     * Set the value of schoolYear
     *
     * @return  self
     */
    public function setSchoolYear($schoolYear)
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * Get the value of sportType
     */
    public function getSportType()
    {
        return $this->sportType;
    }

    /**
     * Set the value of sportType
     *
     * @return  self
     */
    public function setSportType($sportType)
    {
        $this->sportType = $sportType;

        return $this;
    }

    /**
     * Get the value of courseInterests
     */ 
    public function getCourseInterests()
    {
        return $this->courseInterests;
    }

    /**
     * Set the value of courseInterests
     *
     * @return  self
     */ 
    public function setCourseInterests($courseInterests)
    {
        $this->courseInterests = $courseInterests;

        return $this;
    }

    /**
     * Get the value of goingOutType
     */ 
    public function getGoingOutType()
    {
        return $this->goingOutType;
    }

    /**
     * Set the value of goingOutType
     *
     * @return  self
     */ 
    public function setGoingOutType($goingOutType)
    {
        $this->goingOutType = $goingOutType;

        return $this;
    }

        /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of profilePicture
     */ 
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * Set the value of profilePicture
     *
     * @return  self
     */ 
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get the value of passwordForEmailVerification
     */ 
    public function getPasswordForEmailVerification()
    {
        return $this->passwordForEmailVerification;
    }

    /**
     * Set the value of passwordForEmailVerification
     *
     * @return  self
     */ 
    public function setPasswordForEmailVerification($passwordForEmailVerification)
    {
        if ($passwordForEmailVerification != 1234){
            throw new Exception("Password is incorrect!");
        }
        
        $this->passwordForEmailVerification = $passwordForEmailVerification;

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

    public function save(){
        // connection
        $conn = Db::getConnection();
    
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
