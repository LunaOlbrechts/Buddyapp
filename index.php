<?php
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Buddies.php");

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $number_of_users = UserManager::numberOfUsersInDatabase();
    $number_of_buddy_matches = UserManager::numberOfBuddyMatches();
    
    $currentUser = UserManager::getUserFromDatabase();
    $matchedUsers = UserManager::matchUsersByFilters($currentUser);
    $scoresOfMatchedUsers = UserManager::getScoresOfMatchedUsers($currentUser, $matchedUsers);
    $request = Buddies::checkRequest();
    //var_dump($currentUser);

    if (isset($_POST['chat']) && ($_POST['chat'])) {
        try {
            $_SESSION['reciever_name'] = $_POST['recieverName'];
            $_SESSION['reciever_id'] = $_POST['recieverId'];
            $_SESSION['first_name'] = $_POST['senderName'];
            header("Location: chat.php");
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }
    
    if (isset($_POST['request']) && ($_POST['request'])) {
        header("location: request.php");
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


    <?php if($request == true) : ?>
    <form method="POST">   
        <input type="submit" value="You got a buddy request!" name="request" class="btn btn-primary">
    </form>     
    <?php endif ?>

    <?php // echo(json_encode($_SESSION)); ?>
    <div class="container-fluid">
        <p>
            Er zijn al <?php echo $number_of_users; ?> studenten geregistreerd.
        </p>
        <p>
            Er zijn al <?php echo $number_of_buddy_matches; ?> buddy overeenkomsten gevonden.
        </p>
    </div>

    <!--<?php echo(json_encode($_SESSION)); ?>-->

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
                                <input type="hidden" value="<?php echo htmlspecialchars($user['firstName']) ?>" name="recieverName"></input>
                                <input type="hidden" value="<?php echo htmlspecialchars($user['user_id']) ?>" name="recieverId"></input>
                                <?php foreach ($currentUser as $userName) : ?> 
                                    <input type="hidden" value="<?php echo htmlspecialchars($userName['firstName']) ?>" name="senderName"></input>
                                <?php endforeach ?>
                                <input type="submit" value="Chat" name="chat" class="btn btn-primary"></input>
                                <button><a href="http://localhost/files/GitHub/Buddyapp/view.profile.php?id=<?php echo $user['user_id']; ?>" class="collection__item">Profile
                                </a></button>      
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