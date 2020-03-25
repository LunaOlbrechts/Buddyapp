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

    public function getUserFromDatabase(int $userId) {
        // Query (get user from database)

        //Map to user object
        $user = new User();

        // Set all properties from database to $user

        // return $user;
    }
}



