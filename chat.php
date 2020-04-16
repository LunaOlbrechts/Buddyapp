<?php
use PHPMailer\PHPMailer\PHPMailer;
session_start();

include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Chat.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Buddies.php");


$id =  $_SESSION["user_id"];

include_once(__DIR__ . "/classes/Mail.php");

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if ($_POST['sendMessage'] && !empty($_POST['message'])) {
        try {
            $message = new Chat();
            $message->setMessage($_POST['message']);
            $message->setSenderId($_SESSION['user_id']);
            $message->setSenderName($_SESSION['first_name']);
            $message->setRecieverId($_SESSION['reciever_id']);
            $message->setRecieverName( $_SESSION['reciever_name']);
            
            Chat::sendMessage($message);

        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }
    if ($_POST['buddyRequest'] && !empty($_POST['buddyRequest'])) {
        try {
            $buddy = new Buddies();
            $buddy->setSender($_SESSION['user_id']);
            $buddy->setReciever($_SESSION['reciever_id']);
            Buddies::sendRequest($buddy);
            Mail::sendEmail();
            
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }

    if (isset($_POST['profile']) && ($_POST['profile'])) {
        try {
            $_SESSION['reciever_name'] = $_POST['recieverName'];
            $_SESSION['reciever_id'] = $_POST['recieverId'];
            header("Location: view.profile.php");
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }

} else {
    header("Location: login.php");
}

 


// Get messages for specific chat
$conn = Db::getConnection();
$senderId = $_SESSION['user_id'];
$recieverId = $_SESSION['reciever_id'];

$statement = $conn->prepare("SELECT * FROM tl_chat WHERE (senderId = '" . $senderId . "' AND recieverId = '" . $recieverId . "') OR (senderId = '" . $recieverId . "' AND recieverId = '" . $senderId . "') ORDER BY created_on ASC");
$statement->execute();
$messages = $statement->fetchAll(PDO::FETCH_ASSOC);

$currentUser = UserManager::getUserFromDatabase();
$matchedUsers = UserManager::matchUsersByFiltersChat();
$scoresOfMatchedUsers = UserManager::getScoresOfMatchedUsers($currentUser, $matchedUsers);

?>
<style>
    span {
        color: #007bff;
        font-weight: bold;
    }

    .container {
        margin-top: 3%;
        width: 60%;
        background-color: #F2F2F2;
        padding-right: 10%;
        padding-left: 10%;
    }

    .display-chat {
        height: 50vh;
        margin-bottom: 4%;
        overflow: auto;
        padding: 15px;
        border-bottom: 1px solid #007bff;
    }

    .message {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        padding: 5px;
        margin-bottom: 3%;
        width: auto;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>

<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>
    <div class="container">
        <?php foreach ($scoresOfMatchedUsers as $matchedUser => $user) : ?>
            <?php if ($user['user_id'] != $_SESSION['user_id']) : ?>
                <p class="card-text">Je hebt deze kenmerken gemeen met <?php echo $user['firstName']?>:</p>
                <?php foreach ($user['matches'] as $match) : ?>
                    <ul>
                        <?php if (trim($match) !== '') : ?><li><?php echo $match . ", " ?></li><?php endif ?>
                    </ul>
                <?php endforeach ?>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    <div class="container">
        <div class="display-chat">
            <?php foreach ($messages as $message) : ?>
                <span><?php echo $message['sender']; ?></span>
                <div class="message">
                    <p>
                        <?php echo $message['message']; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <textarea name="message" class="form-control" placeholder="Type your message here..."></textarea>
            <div class="btn-group" role="group" aria-label="Basic example">
            <input type="hidden" value="<?php echo htmlspecialchars($user['firstName']) ?>" name="recieverName"></input>
            <input type="hidden" value="<?php echo htmlspecialchars($user['user_id']) ?>" name="recieverId"></input>
                <input type="submit" value="Send Message" name="sendMessage" class="btn btn-primary mr-3"></input>
                <input type="submit" value="Be My Buddy" class="btn btn-success" name="buddyRequest"></input>
                <input type="submit" value="View profile" name="profile" class="btn btn-info mt-5"></input>  
            </div>
        </form>
    </div>
</body>

</html>