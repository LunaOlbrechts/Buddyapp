<?php

spl_autoload_register();

if (isset($_POST['userName'])) {

    $userName = $_POST['userName'];
    $conn = \src\BeMyBuddy\Db::getConnection();
    $sql = "SELECT * FROM tl_user WHERE userName='$userName'";
    $results = $conn->query($sql);

    if ($results->rowCount() > 0) {
        $response = "<span style='color: red;'>This username is already taken</span>";
    } else {
        $response = "<span style='color: green;'>Available.</span>";
    }

    echo $response;

    exit();                          
}