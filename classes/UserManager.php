<?php


class UserManager{

    public static function saveCompletedProfile(User $user)  
    {
        $conn = new PDO('mysql:host=localhost;dbname=buddy_app', "root", "root");
        $statement = $conn->prepare("UPDATE tl_users SET city = :location, schoolYear = :schoolYear, 
        sportType = :sportType WHERE id = :id");

        $location = $user->getLocation();
        $schoolYear = $user->getSchoolYear();
        $sportType = $user->getSportType();
        $id = $user->getId();

        $statement->bindValue(":location", $location);
        $statement->bindValue(":schoolYear", $schoolYear);
        $statement->bindValue(":sportType", $sportType);
        $statement->bindValue(":id", $id);

        $result = $statement->execute();

        return $result;
    }

    public function getUserFromDatabase(int $userId) {
        // Query (get user from database)

        //Map to user object
        $user = new User();

        // Set all properties from database to $user

        // return $user;
    }
}



