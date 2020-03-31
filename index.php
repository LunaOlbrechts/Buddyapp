<?php
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();
    
    // change hardcoded values 
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id']= 1;

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
        
        $currentUser = UserManager::getUserFromDatabase();
        $matchedUsers = UserManager::matchUsersByFilters($currentUser);
        $scoresOfMatchedUsers = UserManager::getScoresOfMatchedUsers($currentUser, $matchedUsers);
        
    } 
    else{
        header("Location: login.php");
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php include_once("include/nav.inc.php"); ?>

    <div class="profileMatchesByFilters d-flex justify-content-center">
        <div class="card-group">
        <?php foreach($scoresOfMatchedUsers as $matchedUser =>$user):?>
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $user['firstName']?></h5>
                <p class="card-text"><?php ?></p>
            </div>
            <?php foreach($user['filters'] as $userFilter): ?>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><?php echo $userFilter?></li>
            </ul>
            <?php endforeach ?>
            <div class="card-body">
                <a href="#" class="card-link">Match</a>
            <a href="#" class="card-link">Open chat</a>
            </div>
        </div>
        <?php endforeach ?>
        </div>
    </div>
</body>
</html>