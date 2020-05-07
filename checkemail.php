<?php

include_once(__DIR__ . "/classes/Db.php");

if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT * FROM tl_user WHERE email=:email");
    $statement->bindValue(":email", $email);
    $statement->execute();
    $results = $statement->fetchColumn();


        if (!empty($results)) {
            $response = "<span style='color: red;'>Dit email is al in gebruik</span>";
        } else {
            $response = "<span style='color: green;'>Beschikbaar.</span>";
        }

        echo $response;

        exit();                          
    }
