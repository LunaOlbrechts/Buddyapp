<?php

include_once(__DIR__ . "/classes/Db.php");

if (isset($_POST['userName'])) {

    $userName = $_POST['userName'];
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT * FROM tl_user WHERE userName=:userName");
    $statement->bindValue(":userName", $userName);
    $statement->execute();
    $results = $statement->fetchColumn();

    if (!empty($results)) {
        $response = "<span style='color: red;'>Deze username is al in gebruik</span>";
    } else {
        $response = "<span style='color: green;'>Beschikbaar.</span>";
    }

    echo $response;

    exit();                          
}
