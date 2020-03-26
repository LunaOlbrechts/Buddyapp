<?php


class UserManager{

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
        $statement->bindValue(":courseInterests", json_encode($courseInterests) );
        $statement->bindValue(":schoolYear", $schoolYear);
        $statement->bindValue(":sportType", $sportType);
        $statement->bindValue(":goingOutType", $goingOutType);

        $result = $statement->execute();

        return $result;
    }

    public static function getUserFromDatabase()
    {
        $conn = new PDO("mysql:host=localhost;dbname=buddy_app", "root", "root");

        $statement = $conn->prepare("select * from tl_user where id=1");
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
        $id = 1;

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
        $id = 1;

        $statement->bindValue(":profilePicture", $profilePicture);
        $statement->bindValue(":id", $id);

        $result = $statement->execute();

        return $result;
    }

    public function updateEmail(User $user)
    {
        $email = $user->getEmail();
        $password = $user->getPasswordForEmailVerification();

        if ($password = 1234) {
            $conn = new PDO("mysql:host=localhost;dbname=buddy_app", "root", "root");
            $sql = "UPDATE tl_user SET email = :email WHERE id = :id";
            $statement = $conn->prepare($sql);

            $id = 1;

            $statement->bindValue(":email", $email);
            $statement->bindValue(":id", $id);

            $result = $statement->execute();
        } else {
            throw new Exception("Password is incorrect");
        }

        return $result;
    }
}



