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
}
