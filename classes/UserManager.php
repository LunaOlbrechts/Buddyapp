<?php

class UserManager
{
    public static function saveCompletedProfile(User $user)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE tl_user SET city = :location, mainCourseInterest = :mainCourseInterest, schoolYear = :schoolYear, 
        sportType = :sportType, goingOutType = :goingOutType WHERE id = :id");

        $id = $user->getId();
        $location = $user->getLocation();
        $mainCourseInterest = $user->getMainCourseInterest();
        $schoolYear = $user->getSchoolYear();
        $sportType = $user->getSportType();
        $goingOutType = $user->getGoingOutType();

        $statement->bindValue(":id", $id);
        $statement->bindValue(":location", $location);
        $statement->bindValue(":mainCourseInterest", json_encode($mainCourseInterest));
        $statement->bindValue(":schoolYear", $schoolYear);
        $statement->bindValue(":sportType", $sportType);
        $statement->bindValue(":goingOutType", $goingOutType);

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
        $sql = "SELECT password, id FROM tl_user WHERE email = :email";
        $statement = $conn->prepare($sql);

        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //print_r($result);
        $password = $result["password"];
        $userId = $result["id"];

        //echo $password;
        if (password_verify($passwordEntered, $password)) {
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['logged_in'] = true;
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

    public static function getScoresOfMatchedUsers($currentUser, $matchedUsers)
    {
        $matchedScores = [];

        foreach ($matchedUsers as $matchedUser) {
            $newUser = [
                'user_id' => $matchedUser['id'],
                'firstName' => $matchedUser['firstName'],
                'lastName' => $matchedUser['lastName'],
                'filters' => [
                    "city" => $matchedUser['city'],
                    'mainCourseInterest' => $matchedUser['mainCourseInterest'],
                    'schoolYear' => $matchedUser['schoolYear'],
                    'sportType' => $matchedUser['sportType'],
                    'goingOutType' => $matchedUser['goingOutType'],
                ],
                'score' => 0
            ];

            if ($currentUser[0]['city'] == $matchedUser['city']) {
                $newUser['score'] += 20;
            }

            if ($currentUser[0]['mainCourseInterest'] == $matchedUser['mainCourseInterest']) {
                $newUser['score'] += 20;
            }

            if ($currentUser[0]['schoolYear'] == $matchedUser['schoolYear']) {
                $newUser['score'] += 20;
            }

            if ($currentUser[0]['sportType'] == $matchedUser['sportType']) {
                $newUser['score'] += 20;
            }

            if ($currentUser[0]['goingOutType'] == $matchedUser['goingOutType']) {
                $newUser['score'] += 20;
            }

            $matchedScores[] = $newUser;
        }
        return $matchedScores;
    }
}
