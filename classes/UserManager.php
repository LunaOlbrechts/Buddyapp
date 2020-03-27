<?php


class UserManager
{

    public static function saveCompletedProfile(User $user)
    {
        $conn = new PDO('mysql:host=localhost;dbname=buddy_app', "root", "root");
        $statement = $conn->prepare("UPDATE tl_users SET city = :location, courseInterests = :courseInterests, schoolYear = :schoolYear, 
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
        $conn = new PDO("mysql:host=localhost;dbname=buddy_app", "root", "root");

        $statement = $conn->prepare("select * from tl_user where id=4");
        $statement->execute();
        $userData = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $userData;
    }

    public function updateUserDetails(User $user)
    {
        $conn = new PDO("mysql:host=localhost;dbname=buddy_app", "root", "root");
        $sql = "UPDATE tl_user SET description = :description WHERE id = :id";
        $statement = $conn->prepare($sql);

        $description = $user->getDescription();
        //$email = $user->getEmail();
        // $profilePicture = $user->getProfilePicture();
        $id = 4;

        $statement->bindValue(":description", $description);
        //$statement->bindValue(":email", $email);
        // $statement->bindValue(":profilePicture", $profilePicture);
        $statement->bindValue(":id", $id);

        $result = $statement->execute();

        return $result;
    }

    public function updateUserProfilePicture(User $user)
    {
        $conn = new PDO("mysql:host=localhost;dbname=buddy_app", "root", "root");
        $sql = "UPDATE tl_user SET profilePicture = :profilePicture WHERE id = :id";
        $statement = $conn->prepare($sql);

        $profilePicture = $user->getProfilePicture();
        $id = 4;

        $statement->bindValue(":profilePicture", $profilePicture);
        $statement->bindValue(":id", $id);

        $result = $statement->execute();

        return $result;
    }

    public function updateEmail(User $user)
    {
        $conn = new PDO("mysql:host=localhost;dbname=buddy_app", "root", "root");
        $sql = "SELECT password FROM tl_user WHERE id = 4 LIMIT 1";
        $statement = $conn->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();
        $password = $result[0]["password"];

        $passwordEntered = $user->getPasswordForEmailVerification();
        $email = $user->getEmail();

        if (password_verify($passwordEntered, $password)) {
            $conn = new PDO("mysql:host=localhost;dbname=buddy_app", "root", "root");
            $sql = "UPDATE tl_user SET email = :email WHERE id = :id";
            $statement = $conn->prepare($sql);

            $id = 4;

            $statement->bindValue(":email", $email);
            $statement->bindValue(":id", $id);

            $result = $statement->execute();
        } else {
            throw new Exception("Password is incorrect");
        }

        return $result;
    }

    public static function logIn(User $user){
        $passwordEntered = $user->getPasswordForEmailVerification();
        $email = $user->getEmail();

        $conn = new PDO("mysql:host=localhost;dbname=buddy_app", "root", "");
        $sql = "SELECT password FROM tl_user WHERE email = :email";
        $statement = $conn->prepare($sql);
        $statement->bindValue(":email",$email);
        $statement->execute();
        $result = $statement->fetchAll();
        $password = $result[0]["password"];
            if (password_verify($passwordEntered, $password)) {
                    echo "Wachtwoord juist!";
                    header("Location:index.php");
            } else {
                    throw new Exception("Password is incorrect");
            }
        }
    }