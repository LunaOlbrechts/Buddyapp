<?php

namespace src\BeMyBuddy;

use \PDO;

class Post
{

    private $userId;
    private $title;
    private $description;

    public function save()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_post (userId, title, description) VALUES (:userId, :title, :description)");

        $userid = $this->getUserId();
        $title = $this->getTitle();
        $description = $this->getDescription();

        $statement->bindValue(":userId", $userid);
        $statement->bindValue(":title", $title);
        $statement->bindValue(":description", $description);
        $result = $statement->execute();

        return $result;
    }

    public static function getAllPosts($userId){
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM tl_post WHERE (userId = '" . $userId . "') ORDER BY posted_on ASC");

        $statement->bindValue(":userId", $userId);

        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $posts;
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
}
