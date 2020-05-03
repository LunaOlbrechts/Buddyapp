<?php

include_once(__DIR__ . "/classes/Buddies.php");
include_once(__DIR__ . "/classes/UserManager.php");

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $number_of_users = UserManager::numberOfUsersInDatabase();
    $number_of_buddy_matches = UserManager::numberOfBuddyMatches();

    $currentUser = UserManager::getUserFromDatabase();
    $matchedUsers = UserManager::matchUsersByFilters($currentUser);
    $scoresOfMatchedUsers = UserManager::getScoresOfMatchedUsers($currentUser, $matchedUsers);
    $denyMessage = Buddies::checkDenyMessage();
    $denied = Buddies::printDenyMessage();
    //var_dump($currentUser);

    if (isset($_POST['chat']) && ($_POST['chat'])) {
        try {
            $_SESSION['receiver_name'] = $_POST['receiverName'];
            $_SESSION['receiver_id'] = $_POST['receiverId'];
            header("Location: chat.php");
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }

    if (isset($_POST['request']) && ($_POST['request'])) {
        header("location: request.php");
    }

    if (isset($_POST['DeniedOK']) && ($_POST['DeniedOK'])) {
        Buddies::deleteMessage();
    }
} else {
    header("Location: login.php");
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Buddy app | Home</title>
</head>
<body>

    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <?php if ($denyMessage == true) : ?>
        <?php foreach ($denied as $deny) : ?>
            <div class="alert alert-danger" role="alert">
                <p name="denyMessage">Your buddy request has been denied</p>
                <p>Reason:</p>
                <?php echo htmlspecialchars($deny["message"]) ?>
                <form method="POST">
                    <input type="submit" value="Ok" name="DeniedOK" class="btn-danger">
                </form>
            </div>
        <?php endforeach ?>
    <?php endif ?>

    <div class="card-text amount">
        <div class="flex-amount">
            <div class="amount-students ml-5 mt-2">
                <p>
                    Er zijn al <?php echo $number_of_users; ?> studenten geregistreerd
                </p>
            </div>
            <div class="amount-buddies ml-5">
                <p>
                    Er zijn al <?php echo $number_of_buddy_matches; ?> buddy overeenkomsten gevonden
                </p>
            </div>
        </div>
    </div>

    <div class="profileMatchesByFilters">
        <div class="row-test">
            <?php foreach ($scoresOfMatchedUsers as $matchedUser => $user) : ?>
                <?php if ($user['user_id'] != $_SESSION['user_id']) : ?>
                    <div class="col-sm-6">
                        <div class="card mb-3 person-card">
                            <div style="background-image: url(<?php echo htmlspecialchars($user['profilePicture']) ?>); height: 250px; background-size: cover; background-position: center" ;></div>
                            <div class="card-body">
                                <a href="view.profile.php?id=<?php echo $user['user_id']; ?>" class="collection__item">
                                    <h5 class="card-title"><?php echo htmlspecialchars($user['firstName'] . " " . $user['lastName']) ?></h5>
                                </a>
                                <p class="card-text">jullie hebben deze kenmerken gemeen:</p>
                                <ul>
                                    <?php foreach ($user['matches'] as $match) : ?>
                                        <?php if (trim($match) !== '') : ?><li><?php echo $match . ", " ?></li><?php endif ?>
                                    <?php endforeach ?>
                                </ul>

                                <form method="POST" enctype="multipart/form-data" class="form-person">
                                    <input type="hidden" value="<?php echo htmlspecialchars($user['firstName']) ?>" name="receiverName"></input>
                                    <input type="hidden" value="<?php echo htmlspecialchars($user['user_id']) ?>" name="receiverId"></input>
                                    <input type="submit" value="Chat" name="chat" class="btn btn-primary chat"></input>
                                    <button class="profile-btn btn"><a  href="view.profile.php?id=<?php echo $user['user_id']; ?>" class="collection__item">Bekijk profiel</a></button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>

    <?php include_once(__DIR__ . "/include/footer.inc.php"); ?>

    <script src="script.js"></script>

</body>
</html>