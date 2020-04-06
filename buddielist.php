<?php

    
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();
    $id =  $_SESSION["user_id"];


    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
        $user = new User();
        $user->setId($id);
        $users = Usermanager::matches($user);
       // var_dump($users);            
    } else {
        header("Location: login.php");
    }




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buddy app | Buddy list</title>
</head>
<body>
    <?php include_once("include/nav.inc.php"); ?>
    <div class="container mt-5">
        <h1 class="col-md-4">Buddy list!</h1>


        <?php
        $i = 0;
        foreach($users as $user): 
        ?>
        
            <?php 
            ++$i;
            if($i==1)
            {
                
                 ?>
                <table class="table table-striped table-bordered table-hover">
                <th scope="col">
                    <?php echo $user['firstName'] . " " . $user['lastName'];
                          echo  " is buddies with"; 
                    
           } 
            if($i==2) {

                         echo  $user['firstName'] . " " . $user['lastName']; ?>
                </th>
                </table>
                <?php $i=0;          
            }
           // echo $user['email']; 
           ?>
        
        
        <?php endforeach; ?>
    </div>
</body>
</html>