<?php

include_once(__DIR__ . "/classes/Db.php");

if (isset($_POST['userName'])) {

    $userName = $_POST['userName'];
    $conn = Db::getConnection();
    $sql = "SELECT * FROM tl_user WHERE userName='$userName'";
    $results = $conn->query($sql);

    if ($results->rowCount() > 0) {
        $response = "<span style='color: red;'>Deze username is al in gebruik</span>";
    } else {
        $response = "<span style='color: green;'>Beschikbaar.</span>";
    }

    echo $response;

    exit();                          
}
