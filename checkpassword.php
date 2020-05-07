<?php

if (isset($_POST['signUpCheck'])) {
    if (json_decode($_POST['signUpCheck']) == true) {
        echo "succes";    
    } 
} 
        
