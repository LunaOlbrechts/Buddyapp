<?php

    
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();
    $id =  $_SESSION["user_id"];
    $user1;
    $user2;


    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
        $user = new User();
        $user->setId($id);
        $user1 = Usermanager::matches1($user);
        $user2 = Usermanager::matches2($user);       
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
       // $i = 0;
       // foreach($user1 as $users1): 
        for($i=0, $count = count($user1);$i<$count;$i++):
            $users1 = $user1[$i];
            $users2 = $user2[$i];
        ?>
        
            <?php 
            {
                
                 ?>
                <table class="table table-striped table-bordered table-hover">
                <th scope="col">
                    <?php echo $users1['firstName'] . " " . $users1['lastName'];
                          echo  " is buddies with "; 
                    
           } 
     {
                         echo  $users2['firstName'] . " " . $users2['lastName']; ?>
                </th>
                </table>
                <?php           
            } 
           ?>
    
        <?php endfor; ?>
    </div>
</body>
</html>