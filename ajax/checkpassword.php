<?php
    include_once(__DIR__ . "/../classes/User.php");


    if(isset($_POST['signUpCheck'])){
       if(json_decode($_POST['signUpCheck']) == true) {
            echo "success";    
        } 
    } 
            
?>