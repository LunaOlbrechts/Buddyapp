<?php
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $currentUser = UserManager::getUserFromDatabase();
    $matchedUsers = UserManager::matchUsersByFilters($currentUser);
    $scoresOfMatchedUsers = UserManager::getScoresOfMatchedUsers($currentUser, $matchedUsers);

    if ($_POST['chat']) {
        try {
            $_SESSION['reciever'] = $_POST['reciever'];
            header("Location: chat.php");
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }
} else {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Home</title>
</head>

<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <?php echo(json_encode($_SESSION)); ?>

    <div class="profileMatchesByFilters d-flex justify-content-center">
        <div class="card-group">
            <?php foreach ($scoresOfMatchedUsers as $matchedUser => $user) : ?>
                <?php if ($user['user_id'] != $_SESSION['user_id']) : ?>
                    <div class="card" style="width: 300px;">
                        <div style="background-image: url(<?php echo htmlspecialchars($user['profilePicture']) ?>); width: 300px; height: 250px; background-size: cover; background-position: center" ;></div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($user['firstName'] . " " . $user['lastName']) ?></h5>
                            <p class="card-text">jullie hebben deze kenmerken gemeen:</p>
                            <?php foreach ($user['matches'] as $match) : ?>
                                <ul>
                                    <?php if (trim($match) !== '') : ?><li><?php echo $match . ", " ?></li><?php endif ?>
                                </ul>
                            <?php endforeach ?>
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" value="<?php echo htmlspecialchars($user['user_id']) ?>" name="reciever"></input>
                                <div class="btn-group" role="group" >        
                                    <input type="submit" value="Chat" name="chat" class="btn btn-primary mr-3"></input>
                                    <input type="submit" value="Be My Buddy" name="buddy" class="btn btn-success"></input>
                                </div>            
                            </form>
                        </div>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>