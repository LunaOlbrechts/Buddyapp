<?php

class UserManager
{

    public static function saveCompletedProfile(User $user)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE tl_user SET city = :location, courseInterests = :courseInterests, schoolYear = :schoolYear, 
        sportType = :sportType, goingOutType = :goingOutType WHERE id = :id");

        $id = $user->getId();
        $location = $user->getLocation();
        $courseInterests = $user->getCourseInterests();
        $schoolYear = $user->getSchoolYear();
        $sportType = $user->getSportType();
        $goingOutType = $user->getGoingOutType();

        $statement->bindValue(":id", $id);
        $statement->bindValue(":location", $location);
        $statement->bindValue(":courseInterests", json_encode($courseInterests));
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

        $user->setId($userId);

        //echo $password;
        if (password_verify($passwordEntered, $password)) {
            $succesMessage= "You are logged in";
            return $succesMessage;
        } else {
            throw new Exception("Email & password don't match");
        }
    }

    public static function matches(User $user)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("select * from tl_user");
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $users;

    }
    
}
