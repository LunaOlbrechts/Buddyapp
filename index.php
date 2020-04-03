<?php
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
        $currentUser = UserManager::getUserFromDatabase();
        $matchedUsers = UserManager::matchUsersByFilters($currentUser);
        $scoresOfMatchedUsers = UserManager::getScoresOfMatchedUsers($currentUser, $matchedUsers);
    } 
    else {
        header("Location: login.php");
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Home</title>
</head>
<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <div class="profileMatchesByFilters d-flex justify-content-center">
        <div class="card-group">
        <?php foreach($scoresOfMatchedUsers as $matchedUser =>$user):?>
        <?php if($user['user_id'] != $_SESSION['user_id']): ?>
        <div class="card" style="width: 18rem;">
            <img src="<?php echo $user['profilePicture']?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $user['firstName'] . " " . $user['lastName'] ?></h5>
                <p class="card-text">jullie hebben deze kenmerken gemeen:</p>
                <?php foreach($user['matches'] as $match):?>
                <ul>
                    <?php if(trim($match) !== ''):?><li><?php echo $match . ", " ?></li><?php endif ?>
                </ul>
                <?php endforeach?>
            </div>

            <div class="card-body">
                <a href="#" class="card-link" id="match">Match</a>
            </div>
        </div>
        <?php endif ?>
        <?php endforeach ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>