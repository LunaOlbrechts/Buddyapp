<?php

include_once(__DIR__ . "/Db.php");

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
    private $passwordForVerification;
    private $newPassword;
    private $repeatedNewPassword;


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
            throw new Exception("The two passwords do not match");
        }
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
        if (empty($_POST['firstname'])) {
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
        if (empty($_POST['lastname'])) {
            throw new Exception("Lastname cannot be empty");
        }
        $this->lastName = $lastName;

        return $this;
    }

    public function save()
    {
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
            $tmp = explode('@', $email);
            $domain = array_pop($tmp);

            if (!in_array($domain, $domainWhiteList)) {
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

    /**
     * Get the value of newPassword
     */ 
    public function getNewPassword()
    {
        return $this->newPassword;
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
}
