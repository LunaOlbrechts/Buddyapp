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
    <h1 class="col-md-4" >This is a list of all people with their buddy!</h1>

    <?php foreach($users as $user): ?>
        <h2><?php echo $user['email']; ?></h2>

    <?php endforeach; ?>
</body>
</html>