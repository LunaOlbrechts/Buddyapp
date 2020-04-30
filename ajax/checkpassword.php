<?php
    include_once(__DIR__ . "/../classes/User.php");


    if(isset($_POST['signUpCheck'])){
       if(json_decode($_POST['signUpCheck']) == true) {
            $result = "<input class='btn border' name='signup-btn' id='btnSignUp' type='submit' value='Sign me up'>";    
        } else {
            $result = "<span style='color: red;'>Password is not strong enough, button will apear when password is strong enough.</span>";
        }
        echo $result;
        
       exit();
    } 
            
?>