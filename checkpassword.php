<?php

spl_autoload_register();

    if(isset($_POST['signUpCheck'])){
       if(json_decode($_POST['signUpCheck']) == true) {
            echo "success";    
        } 
    } 
            
?>