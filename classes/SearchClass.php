<?php
include_once(__DIR__ . "/Db.php");

class SearchClass
{

    public static function findClass($searchField)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM tl_classfinder WHERE LOWER(classRoom) LIKE LOWER(:classRoom)");

        $statement->bindValue(':classRoom', $searchField);

        $statement->execute();

        $count = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $count;
    }

    public static function autocompleteClass($searchClass)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT classRoom FROM tl_classfinder WHERE LOWER(classRoom) LIKE LOWER(:classRoom)");

        $statement->bindValue(':classRoom', '%' . $searchClass . '%');

        $statement->execute();

        $autocomplete = $statement->fetch(PDO::FETCH_ASSOC);
        return $autocomplete;
    }
}
