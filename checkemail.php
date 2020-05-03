<?php

use \src\BeMyBuddy\Db;

spl_autoload_register();

if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $conn = Db::getConnection();
    $sql = "SELECT * FROM tl_user WHERE email='$email'";
    $results = $conn->query($sql);

        if ($results->rowCount() > 0) {
            $response = "<span style='color: red;'>This email is already taken</span>";
        } else {
            $response = "<span style='color: green;'>Available.</span>";
        }

        echo $response;

        exit();                          
    }
