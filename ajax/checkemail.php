<?php

include_once(__DIR__ . "/classes/Db.php");

if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $conn = Db::getConnection();
    $sql = "SELECT * FROM tl_user WHERE email='$email'";
    $results = $conn->query($sql);

        if ($results->rowCount() > 0) {
            $response = "<span style='color: red;'>Dit email is al in gebruik</span>";
        } else {
            $response = "<span style='color: green;'>Beschikbaar.</span>";
        }

        echo $response;

        exit();                          
    }
