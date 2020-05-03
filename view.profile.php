<?php

spl_autoload_register();
session_start();

$id =  $_SESSION["user_id"];

$profileId = $_GET['id'];

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $posts = \src\BeMyBuddy\Post::getAllPosts($profileId);
    $buddy = new \src\BeMyBuddy\Buddies();
    $id = $_GET['id'];
    $otherId = $_SESSION["user_id"];
    $haveRequestOrBuddy = \src\BeMyBuddy\Buddies::haveRequestOrBuddy($id, $otherId);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $userdata = \src\BeMyBuddy\UserManager::getUserFromDatabaseById($id);
    } else {
        die("An ID is missing. 🙄");
    }

    if (isset($_POST['chat']) && ($_POST['chat'])) {
        try {
            $_SESSION['sender'] = $_POST['request'];
            header("Location: chat.php");
        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }
    }

    if (isset($_POST["buddyRequest"]) && $_POST['buddyRequest'] && !empty($_POST['buddyRequest'])) {
        try {
            $buddy = new \src\BeMyBuddy\Buddies();
            $buddy->setSender($_SESSION['user_id']);
            $buddy->setReceiver($_GET['id']);
            \src\BeMyBuddy\Buddies::sendRequest($buddy);
            \src\BeMyBuddy\Mail::sendEmailBuddyRequest();
        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }
    }

    // PRINT BUDDY ON PROFILE
    $buddy = new \src\BeMyBuddy\Buddies();
    $haveBuddy = \src\BeMyBuddy\Buddies::haveBuddy($id);

    if ($haveBuddy == 1) {
        $currentuser = \src\BeMyBuddy\Buddies::displayBuddy($id);
    }
} else {
    header("Location: login.php");
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buddy app | Profiel</title>
</head>
<body>

    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <div class="d-flex justify-content-center">
        <?php foreach ($userdata as $users) : ?>
            <div class="card">
                <h2 class="card-title">Profiel van <?php echo htmlspecialchars($users['firstName']) . " " . htmlspecialchars($users['lastName']) ?></h2>
                <div style="background-image: url(<?php echo htmlspecialchars($users['profilePicture']) ?>); width: auto; height: 250px; background-size: cover; background-position: center" ;></div>                <p class="card-text">Description: <?php echo htmlspecialchars($users['description']) ?></p>
                <p class="card-text">Woonplaats: <?php echo htmlspecialchars($users['city']) ?></p>
                <p class="card-text">opleidingsjaar: <?php echo htmlspecialchars($users['schoolYear']) ?></p>
                <p class="card-text">opleidingsintresse: <?php echo htmlspecialchars($users['mainCourseInterest']) ?></p>
                <p class="card-text">Sport type: <?php echo htmlspecialchars($users['sportType']) ?></p>
                <p class="card-text">Uitgaanstype: <?php echo htmlspecialchars($users['goingOutType']) ?></p>
                <?php if ($haveBuddy == false) : ?>
                    <p class="card-text">Buddy: <?php echo htmlspecialchars($users['buddyType']) ?></p>
                <?php endif ?>


                <?php if ($haveBuddy == true) : ?>
                    <?php foreach ($currentuser as $currentusers) : ?>
                        <p class="card-text">My buddy is: <?php echo htmlspecialchars($currentusers['firstName']) . " " . htmlspecialchars($currentusers['lastName']) ?></p>
                    <?php endforeach ?>
                <?php endif ?>            
                        

                <?php if (isset($error)) : ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <?php if ($haveRequestOrBuddy == 0) : ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <input type="hidden" value="<?php echo htmlspecialchars($users['firstName']) ?>" name="receiverName"></input>
                            <input id="receiver" type="hidden" value="<?php echo htmlspecialchars($users['id']) ?>" name="receiverId"></input>
                            <input type="submit" value="Be My Buddy" class="btn btn-success" name="buddyRequest"></input>
                        </div>
                    </form>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>

    <div class="container">
        <?php foreach ($userdata as $users) : ?>
            <h2>Posts van <?php echo htmlspecialchars($users['firstName']) ?> :</h2>
        <?php endforeach ?>
        <div class="container m-0 p-0">
            <?php foreach ($posts as $post) : ?>
                <div class="container mt-3 mb-5 p-0">
                    <h2><?php echo htmlspecialchars($post['title']) ?></h2>
                    <p><?php echo htmlspecialchars($post['description']) ?></p>
                    <p><?php $date = date_create($post['posted_on']);
                        echo htmlspecialchars(date_format($date, 'd/m/Y')) ?></p>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</body>
</html>