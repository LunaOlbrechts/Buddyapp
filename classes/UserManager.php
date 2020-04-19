<?php

class UserManager
{
    public static function save(User $user)
    {
        $conn = Db::getConnection();

        // check if nothing is empty

        if (isset($_POST['signup-btn'])) {
            
            // CHECK IF EMAIL IS TAKEN
            if (isset($_POST['email'])) {
                
                $email = $user->getEmail();
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

            $firstName = $user->getFirstName();
            $lastName = $user->getLastName();
            $email = $user->getEmail();
            $password = $user->getPassword();

            $statement = $conn->prepare("INSERT INTO tl_user (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password) ");

            $statement->bindValue(":firstName", $firstName);
            $statement->bindValue(":lastName", $lastName);
            $statement->bindValue(":email", $email);
            $statement->bindValue(":password", $password);

            $statement->execute();
            $id = $conn->lastInsertId();
            
            echo "saved to database";

            // return result
            return $id;
        }
    }

    public static function saveCompletedProfile(User $user)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE tl_user SET city = :location, mainCourseInterest = :mainCourseInterest, schoolYear = :schoolYear, 
        sportType = :sportType, goingOutType = :goingOutType, buddyType = :buddyType WHERE id = :id");

        $id = $_SESSION['user_id'];
        $location = $user->getLocation();
        $mainCourseInterest = $user->getMainCourseInterest();
        $schoolYear = $user->getSchoolYear();
        $sportType = $user->getSportType();
        $goingOutType = $user->getGoingOutType();
        $buddyType = $user->getBuddyType();

        $statement->bindValue(":id", $id);
        $statement->bindValue(":location", $location);
        $statement->bindValue(":mainCourseInterest", $mainCourseInterest);
        $statement->bindValue(":schoolYear", $schoolYear);
        $statement->bindValue(":sportType", $sportType);
        $statement->bindValue(":goingOutType", $goingOutType);
        $statement->bindValue(":buddyType", $buddyType);

        $result = $statement->execute();

        return $result;
    }

    public static function getUserFromDatabase()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("select * from tl_user where id= :id");

        $statement->bindValue(":id", $_SESSION["user_id"]);

        $statement->execute();
        $userData = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $userData;
    }

    public static function getUserFromDatabaseByEmail($email)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("select * from tl_user where email= :email");

        $statement->bindValue(":email", $email);

        $statement->execute();
        $userData = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $userData;
    }

    public static function getUserFromDatabaseById($id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("select * from tl_user where id= :id");

        $statement->bindValue(":id", $id);

        $statement->execute();
        $userData = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $userData;
    }

    public function updateUserDetails(User $user)
    {
        $conn = Db::getConnection();
        $sql = "UPDATE tl_user SET description = :description WHERE id = :id";
        $statement = $conn->prepare($sql);

        $description = $user->getDescription();
        $id = $user->getId();

        $statement->bindValue(":description", $description);
        $statement->bindValue(":id", $id);

        $result = $statement->execute();

        return $result;
    }

    public function updateUserProfilePicture(User $user)
    {
        $conn = Db::getConnection();
        $sql = "UPDATE tl_user SET profilePicture = :profilePicture WHERE id = :id";
        $statement = $conn->prepare($sql);

        $profilePicture = $user->getProfilePicture();
        $id = $user->getId();

        $statement->bindValue(":profilePicture", $profilePicture);
        $statement->bindValue(":id", $id);

        $result = $statement->execute();

        return $result;
    }

    public function updateEmail(User $user)
    {
        $conn = Db::getConnection();
        $sql = "SELECT password FROM tl_user WHERE id = :id LIMIT 1";
        $statement = $conn->prepare($sql);

        $id = $user->getId();
        $statement->bindValue(":id", $id);
        $statement->execute();

        $result = $statement->fetchAll();
        $password = $result[0]["password"];

        $passwordEntered = $user->getPasswordForVerification();
        $email = $user->getEmail();

        if (password_verify($passwordEntered, $password)) {
            $conn = Db::getConnection();
            $sql = "UPDATE tl_user SET email = :email WHERE id = :id";
            $statement = $conn->prepare($sql);

            $statement->bindValue(":email", $email);
            $statement->bindValue(":id", $id);

            $result = $statement->execute();
        } else {
            throw new Exception("Password is incorrect");
        }

        return $result;
    }

    public static function updatePassword(User $user)
    {
        $oldPassword = $user->getPasswordForVerification();
        $newPassword = $user->getNewPassword();
        $repeatedNewPassword = $user->getRepeatedNewPassword();

        $conn = Db::getConnection();
        $sql = "SELECT password FROM tl_user WHERE id = :id LIMIT 1";
        $statement = $conn->prepare($sql);
        $id = $user->getId();
        $statement->bindValue(":id", $id);
        $statement->execute();

        $result = $statement->fetchAll();
        $password = $result[0]["password"];

        if ($newPassword = $repeatedNewPassword) {
            if (password_verify($oldPassword, $password)) {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
                $conn = Db::getConnection();
                $sql = "UPDATE tl_user SET password = :password WHERE id = :id";
                $statement = $conn->prepare($sql);

                $statement->bindValue(":password", $hashedNewPassword);
                $statement->bindValue(":id", $id);

                $result = $statement->execute();
            } else {
                throw new Exception("Old Password is incorrect");
            }
        } else {
            throw new Exception("Reapated new password is not the same!");
        }
    }

    public static function logIn(User $user)
    {
        $passwordEntered = $user->getPasswordForVerification();
        $email = $user->getEmail();

        $conn = Db::getConnection();
        $sql = "SELECT password, id, firstName, lastName FROM tl_user WHERE email = :email";
        $statement = $conn->prepare($sql);

        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //print_r($result);
        $password = $result["password"];
        $userId = $result["id"];
        $firstName = $result[0]["firstName"];
        $lastName = $result["lastName"];
    
        //echo $password;
        if (password_verify($passwordEntered, $password)) {
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['logged_in'] = true;
            $_SESSION['first_name'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            header("Location:complete.profile.php");  //redirect moet in de frontend
        } else {
            throw new Exception("Email & password don't match");
        }
    }

    public static function matchUsersByFilters($currentUser)
    {
        $location = $currentUser[0]['city'];
        $mainCourseInterest = $currentUser[0]['mainCourseInterest'];
        $schoolYear = $currentUser[0]['schoolYear'];
        $sportType = $currentUser[0]['sportType'];
        $goingOutType = $currentUser[0]['goingOutType'];

        $conn = Db::getConnection();

        //Select users that have minimum one match with the current user filters 

        $statement = $conn->prepare("SELECT * FROM tl_user WHERE city = :city OR mainCourseInterest = :mainCourseInterest
        OR schoolYear = :schoolYear OR sportType = :sportType OR goingOutType = :goingOutType");

        $statement->bindValue(":city", $location);
        $statement->bindValue(":mainCourseInterest", $mainCourseInterest);
        $statement->bindValue(":schoolYear", $schoolYear);
        $statement->bindValue(":sportType", $sportType);
        $statement->bindValue(":goingOutType", $goingOutType);

        $statement->execute();
        $matchedUsers = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $matchedUsers;
    }

    public static function matchUsersByFiltersChat()
    {
        $conn = Db::getConnection();
        //Select users that have minimum one match with the current user filters 

        $statement = $conn->prepare("SELECT * FROM tl_user WHERE firstName = :firstName AND id = :id");

        $nameReciever = $_SESSION['reciever_name'];
        $idReciever = $_SESSION['reciever_id'];

        $statement->bindValue(":firstName", $nameReciever);
        $statement->bindValue(":id", $idReciever);


        $statement->execute();
        $matchedUsers = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $matchedUsers;
    }

    public static function getScoresOfMatchedUsers($currentUser, $matchedUsers)
    {
        $matchedScores = [];

        foreach ($matchedUsers as $matchedUser) {
            $newUser = [
                'user_id' => $matchedUser['id'],
                'firstName' => $matchedUser['firstName'],
                'lastName' => $matchedUser['lastName'],
                'profilePicture' => $matchedUser['profilePicture'],
                'filters' => [
                    "city" => $matchedUser['city'],
                    'mainCourseInterest' => $matchedUser['mainCourseInterest'],
                    'schoolYear' => $matchedUser['schoolYear'],
                    'sportType' => $matchedUser['sportType'],
                    'goingOutType' => $matchedUser['goingOutType'],
                ],
                'score' => 0,
                'matches'=>[
                    "city" => "",
                    "mainCourseInterest" => "",
                    "schoolYear" => "",
                    "sportType" => "",
                    "goingOutType" => ""
                ]
            ];

            if ($currentUser[0]['city'] == $matchedUser['city']) {
                $newUser['score'] += 20;
                $newUser['matches']['city'] = $matchedUser['city'];
            }

            if ($currentUser[0]['mainCourseInterest'] == $matchedUser['mainCourseInterest']) {
                $newUser['score'] += 20;
                $newUser['matches']['mainCourseInterest'] = $matchedUser['mainCourseInterest'];
            }

            if ($currentUser[0]['schoolYear'] == $matchedUser['schoolYear']) {
                $newUser['score'] += 20;
                $newUser['matches']['schoolYear'] = $matchedUser['schoolYear'];
            }

            if ($currentUser[0]['sportType'] == $matchedUser['sportType']) {
                $newUser['score'] += 20;
                $newUser['matches']['sportType'] = $matchedUser['sportType'];
            }

            if ($currentUser[0]['goingOutType'] == $matchedUser['goingOutType']) {
                $newUser['score'] += 20;
                $newUser['matches']['goingOutType'] = $matchedUser['goingOutType'];
            }

            $matchedScores[] = $newUser;
        }
        return $matchedScores;
    }


    public static function matches1()
    {
        $conn = Db::getConnection();
        $nameStatement1 = $conn->prepare("SELECT * FROM tl_user INNER JOIN tl_buddies ON tl_user.id = tl_buddies.user_one");
        $nameStatement1->execute();
        $user1 = $nameStatement1->fetchAll(PDO::FETCH_ASSOC);

        return $user1;

    }

    public static function matches2()
    {
        $conn = Db::getConnection();
        $nameStatement2 = $conn->prepare("SELECT * FROM tl_user INNER JOIN tl_buddies ON tl_user.id = tl_buddies.user_two");
        $nameStatement2->execute();
        $user2 = $nameStatement2->fetchAll(PDO::FETCH_ASSOC);


        return $user2;
    }
    
    
    public static function searchBuddyByFilter()
    {
        $conn = Db::getConnection();

        $mainCourseInterest = $_POST['mainCourseInterest'];
        $schoolYear = $_POST['schoolYear'];
        $sportType = $_POST['sportType'];
        $goingOutType = $_POST['goingOutType'];
        
        /*$statement = $conn->prepare ("SELECT * FROM tl_user WHERE (mainCourseInterest = :mainCourseInterest OR  schoolYear = :schoolYear 
        OR sportType = :sportType OR goingOutType = :goingOutType) AND buddyType = 'wantToBeABuddy'");*/

        $extra = "";

        if(!empty($_POST['mainCourseInterest'])){
            $extra .= "AND mainCourseInterest = :mainCourseInterest";
        }  elseif (!empty($_POST['schoolYear'])){
            $extra .= " AND schoolYear = :schoolYear";
        } elseif (!empty($_POST['sportType'])){
            $extra .= "AND sportType = :sportType";
        } elseif (!empty($_POST['goingOutType'])){
            $extra .= "AND goingOutType = :goingOutType";
        }
        
        $statement = "SELECT * FROM tl_user WHERE buddyType = 'wantToBeABuddy' . $extra";

        $extra = $conn->prepare($statement);

        $extra->bindValue(':mainCourseInterest', $mainCourseInterest);
        $extra->bindValue(':schoolYear', $schoolYear);
        $extra->bindValue(':sportType', $sportType);
        $extra->bindValue(':goingOutType', $goingOutType);

        $extra->execute(); 

        $count = $extra->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($_POST);
        //var_dump($count);
        return $count;
    }

        /*if(isset($_POST['mainCourseInterest'])){
            $mainCourseInterest = $_POST['mainCourseInterest'];
        } elseif (isset($_POST['schoolYear'])){
            $schoolYear = $_POST['schoolYear'];
        } elseif (isset($_POST['sportType'])){
            $sportType = $_POST['sportType'];
        } elseif (isset($_POST['goingOutType'])){
            $goingOutType = $_POST['goingOutType'];
        }*/
    
        /*if(isset($_POST['mainCourseInterest'])){
            if($_POST['mainCourseInterest']){
                $statement = "SELECT * FROM tl_user WHERE (mainCourseInterest = :mainCourseInterest) AND buddyType = 'wantToBeABuddy'";
            } 
        } elseif (isset($_POST['schoolYear'])){
            if($_POST['schoolYear']){
                $statement = "SELECT * FROM tl_user WHERE (schoolYear = :schoolYear) AND buddyType = 'wantToBeABuddy'";
            }
        } elseif (isset($_POST['sportType'])){
            if($_POST['sportType']){
                $statement = "SELECT * FROM tl_user WHERE (sportType = :sportType) AND buddyType = 'wantToBeABuddy'";
            }
        }*/

        /*
        $conn = Db::getConnection();

        //Select users that have minimum one match with the current user filters 

        $statement = $conn->prepare("SELECT * FROM tl_user WHERE firstName LIKE :%searchFirstName% OR lastName LIKE :%searchFirstName% OR city = :city OR mainCourseInterest = :mainCourseInterest
        OR schoolYear = :schoolYear OR sportType = :sportType OR goingOutType = :goingOutType");

        $statement->bindValue(":%searchFirstName%", $searchFirstName);
        $statement->bindValue(":%searchFirstName%", $searchLastName);
        $statement->bindValue(":city", $location);
        $statement->bindValue(":mainCourseInterest", $mainCourseInterest);
        $statement->bindValue(":schoolYear", $schoolYear);
        $statement->bindValue(":sportType", $sportType);
        $statement->bindValue(":goingOutType", $goingOutType);

        $statement->execute();
        $searchBuddy = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $searchBuddy;*/

     public static function searchName()
     {
        $conn = Db::getConnection();

        $searchField = $_SESSION['searchField'];

        $statement = ("SELECT * FROM tl_user WHERE LOWER(firstName) LIKE LOWER(:name) OR LOWER(lastName) LIKE LOWER(:name)");
        
        $query = $conn->prepare($statement);
        
        $query->bindValue(':name', '%'.$searchField.'%');
        //var_dump($searchField);

        $query->execute();
        //"SELECT * from tl_user WHERE firstName LIKE '%$searchName% OR lastName LIKE '%$searchName%"
        
        $count = $query->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($count);
        //var_dump($_POST);
        return $count;
     }

     public static function numberOfUsersInDatabase()
     {
        $conn = Db::getConnection();

        $statement = "SELECT count(*) FROM tl_user";
        $result = $conn->prepare($statement);

        $result->execute();
        $number_of_users = $result->fetchColumn();

        return $number_of_users;
        //var_dump($number_of_users);
        //echo $number_of_users;
     }

     public static function numberOfBuddyMatches()
     {
        $conn = Db::getConnection();

        $statement = "SELECT count(*) FROM tl_buddies";
        $result = $conn->prepare($statement);

        $result->execute();
        $number_of_buddy_matches = $result->fetchColumn();

        return $number_of_buddy_matches;
        //echo $number_of_buddy_matches;
     }


}
