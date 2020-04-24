<?php
    include_once(__DIR__ . "/../classes/User.php");


    if(isset($_POST['signUpCheck'])){
       if(json_decode($_POST['signUpCheck']) == true) {
            $response = "<span style='color: green;'>Password is strong enough</span>";
            $result = "not so hello";
        } else {
            $response = "<span style='color: red;'>Password is not strong enough</span>";
            $result = "hello";
        }
        echo $response;
        echo $result;
       exit();
    } 
            
?>