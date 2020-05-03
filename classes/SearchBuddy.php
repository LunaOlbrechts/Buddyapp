<?php

include_once(__DIR__ . "/Db.php");

class SearchBuddy
{

    public static function searchBuddyByFilter($mainCourseInterest, $schoolYear, $sportType, $goingOutType)
    {
        $conn = Db::getConnection();

        /*$mainCourseInterest = $searchBuddy->getMainCourseInterest();
        $schoolYear = $searchBuddy->getSchoolYear();
        $sportType = $searchBuddy->getSportType();
        $goingOutType = $searchBuddy->getGoingOutType();*/

        $statement = $conn->prepare("SELECT * FROM tl_user WHERE (mainCourseInterest = :mainCourseInterest OR  schoolYear = :schoolYear 
        OR sportType = :sportType OR goingOutType = :goingOutType) AND buddyType = 'wantToBeABuddy'");

        $statement->bindValue(':mainCourseInterest', $mainCourseInterest);
        $statement->bindValue(':schoolYear', $schoolYear);
        $statement->bindValue(':sportType', $sportType);
        $statement->bindValue(':goingOutType', $goingOutType);

        $statement->execute();

        $count = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $count;
    }

    /*$extra = "";

        if (!empty($_POST['mainCourseInterest'])) {
            $extra .= "AND mainCourseInterest = :mainCourseInterest";
        } elseif (!empty($_POST['schoolYear'])) {
            $extra .= " AND schoolYear = :schoolYear";
        } elseif (!empty($_POST['sportType'])) {
            $extra .= "AND sportType = :sportType";
        } elseif (!empty($_POST['goingOutType'])) {
            $extra .= "AND goingOutType = :goingOutType";
        }
        
        $statement = "SELECT * FROM tl_user WHERE buddyType = 'wantToBeABuddy' . $extra";*/

    //$query = $conn->prepare($statement);


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

    public static function searchName($searchField)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM tl_user WHERE LOWER(firstName) LIKE LOWER(:name) OR LOWER(lastName) LIKE LOWER(:name)");

        $statement->bindValue(':name', '%' . $searchField . '%');

        $statement->execute();

        $count = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $count;
    }

    public static function autocompleteSearchName($input)
    {
        $conn = Db::getConnection();
        $statement = ("SELECT Firstname, lastName FROM tl_user WHERE firstName LIKE :name OR lastName LIKE :name LIMIT 1");
        $query = $conn->prepare($statement);

        $query->bindValue(':name', $input . '%');

        $query->execute();

        $suggestion = $query->fetch(PDO::FETCH_ASSOC);

        return $suggestion;
    }
}
