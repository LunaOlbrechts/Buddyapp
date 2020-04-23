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

    public static function getComments()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM tl_forum_comment LEFT JOIN tl_forum_questions ON tl_forum_questions.id = tl_forum_comment.forum_question_id");

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
}
