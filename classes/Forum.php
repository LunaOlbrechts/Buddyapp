<?php

use function PHPSTORM_META\type;

class Forum
{
    public static function getQuestions()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM tl_forum_questions");

        $result = $statement->execute();
        $questions = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return $questions;
        }

        return false;
    }

    public static function saveQuestion($question, $username)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_forum_questions (user_id, question, userName, pinned, date) VALUES (:user_id, :question, :userName, :pinned, :date)");
        $today = strval(date("y-m-d"));     
        
        $statement->bindValue(":user_id", $_SESSION['user_id']);
        $statement->bindValue(":userName", $username);
        $statement->bindValue(":question", $question);
        $statement->bindValue(":pinned", 0);
        $statement->bindValue(":date", $today);

        $result = $statement->execute();
        if ($result) {
            return true;
        }

        return false;
    }

    public static function getComments()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM tl_forum_comment");
        // LEFT JOIN tl_forum_questions ON tl_forum_questions.id = tl_forum_comment.forum_question_id

        $result = $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return $comments;
        }

        return false;
    }

    public static function saveComment($comment, $username)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO tl_forum_comment (forum_question_id, user_id, comment, userName) VALUES (:forum_question_id, :user_id, :comment, :userName)");

        $questionId = $_POST['questionId'];
        $statement->bindValue(":comment", $comment);
        $statement->bindValue(":forum_question_id", $questionId);
        $statement->bindValue(":user_id", $_SESSION['user_id']);
        $statement->bindValue(":userName", $username);

        $result = $statement->execute();

        if ($result) {
            return true;
        }

        return false;
    }

    public static function savePinnedQuestion()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE tl_forum_questions SET pinned = :pinned WHERE id = :id");

        $questionId = $_POST['questionId'];
        $statement->bindValue(":id", $questionId);
        $statement->bindValue(":pinned", 1);

        $result = $statement->execute();

        if ($result) {
            return true;
        }

        return false;
    }

    public static function getPinnedQuestion()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT *  FROM tl_forum_questions WHERE pinned = :pinned");

        $statement->bindValue(":pinned", 1);

        $result = $statement->execute();
        $questions = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return $questions;
        }

        return false;
    }

    public static function deletePinnedQuestion()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE tl_forum_questions SET pinned = :pinned WHERE id = :id");

        $questionId = $_POST['questionId'];
        $statement->bindValue(":id", $questionId);
        $statement->bindValue(":pinned", 0);

        $result = $statement->execute();

        if ($result) {
            return true;
        }

        return false;
    }
    
}
