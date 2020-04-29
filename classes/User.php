<?php

include_once(__DIR__ . "/Db.php");

class User
{
    private $id;
    private $firstName;
    private $lastName;
    private $userName;
    private $email;
    private $password;
    private $location;
    private $mainCourseInterest;
    private $schoolYear;
    private $sportType;
    private $goingOutType;
    private $description;
    private $profilePicture;
    private $passwordForVerification;
    private $newPassword;
    private $repeatedNewPassword;
    private $buddyType;
    private $matchId;
    private $status;
    private $searchField;
    private $class;

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
        if (empty($_POST['firstName'])) {
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
        if (empty($_POST['lastName'])) {
            throw new Exception("Lastname cannot be empty");
        }

        $this->lastName = $lastName;

        return $this;
    }

    
    /**
     * Get the value of userName
     */ 
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set the value of userName
     *
     * @return  self
     */ 
    public function setUserName($userName)
    {

        if (empty($_POST['userName'])) {
            throw new Exception("Username cannot be empty");
        }

        $this->userName = $userName;

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
        if (empty($_POST['email'])) {
            throw new Exception("E-mail cannot be empty");
        }

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
        if (empty($_POST['password'])) {
            throw new Exception("Password cannot be empty");
        }
        if (isset($_POST['password']) && $_POST['password'] !== $_POST['passwordconf']) {
            throw new Exception("Can't register you, the two passwords do not match");
        }

        $this->password = $password;

        return $this;
    }

     /**
     * Get the value of passwordForVerification
     */
    public function getPasswordForVerification()
    {
        return $this->passwordForVerification;
    }

    /**
     * Set the value of passwordForVerification
     *
     * @return  self
     */
    public function setPasswordForVerification($passwordForVerification)
    {
        $this->passwordForVerification = $passwordForVerification;

        return $this;
    }

     /**
     * Set the value of newPassword
     *
     * @return  self
     */ 
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    /**
     * Get the value of repeatedNewPassword
     */ 
    public function getRepeatedNewPassword()
    {
        return $this->repeatedNewPassword;
    }

    /**
     * Set the value of repeatedNewPassword
     *
     * @return  self
     */ 
    public function setRepeatedNewPassword($repeatedNewPassword)
    {
        $this->repeatedNewPassword = $repeatedNewPassword;

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
        if (empty($location)) {
            $showError = true;
            $message = "Location can't be empty";
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
        if (empty($schoolYear)) {
            $showError = true;
            $message = "school year can't be empty";
            throw new Exception($message);
        }

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
        if (empty($sportType)) {
            $showError = true;
            $message = "sport type can't be empty";
            throw new Exception($message);
        }

        $this->sportType = $sportType;

        return $this;
    }

    /**
     * Get the value of courseInterests
     */
    public function getMainCourseInterest()
    {
        return $this->mainCourseInterest;
    }

    /**
     * Set the value of courseInterests
     *
     * @return  self
     */
    public function setMainCourseInterest($mainCourseInterest)
    {
        if (empty($mainCourseInterest)) {
            $showError = true;
            $message = "course intererest can't be empty";
            throw new Exception($message);
        }

        $this->mainCourseInterest = $mainCourseInterest;

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
        if (empty($goingOutType)) {
            $showError = true;
            $message = "going-out type can't be empty";
            throw new Exception($message);
        }

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
     * Get the value of newPassword
     */ 
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * Get the value of buddyType
     */ 
    public function getBuddyType()
    {
        return $this->buddyType;
    }

    /**
     * Set the value of buddyType
     *
     * @return  self
     */ 
    public function setBuddyType($buddyType)
    {
        $this->buddyType = $buddyType;
     /* Get the value of matchId
     */
    } 
    public function getMatchId()
    {
        return $this->matchId;
    }

    /**
     * Set the value of matchId
     *
     * @return  self
     */ 
    public function setMatchId($matchId)
    {
        $this->matchId = $matchId;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of searchField
     */ 
    public function getSearchField()
    {
        return $this->searchField;
    }

    /**
     * Set the value of searchField
     *
     * @return  self
     */ 
    public function setSearchField($searchField)
    {
        $this->searchField = $searchField;

        return $this;
    }

    /**
     * Get the value of class
     */ 
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the value of class
     *
     * @return  self
     */ 
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }
}
