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
    $buddy = new Buddies();
    $otherId = $_SESSION["receiver_id"];
    $haveRequestOrBuddy = Buddies::haveRequestOrBuddy($id, $otherId);

    /*if (isset($_POST['sendMessage']) && $_POST['sendMessage'] && !empty($_POST['message'])) {
        try {
            $message = new Chat();
            $message->setMessage($_POST['message']);
            $message->setSenderId($_SESSION['user_id']);
            $message->setSenderName($_SESSION['first_name']);
            $message->setReceiverId($_SESSION['receiver_id']);
            $message->setReceiverName( $_SESSION['receiver_name']);
            
            Chat::sendMessage($message);

        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }
    */
    if (isset($_POST["buddyRequest"]) && $_POST['buddyRequest'] && !empty($_POST['buddyRequest'])) {
        try {
            $buddy = new Buddies();
            $buddy->setSender($_SESSION['user_id']);
            $buddy->setReceiver($_SESSION['receiver_id']);
            Buddies::sendRequest($buddy);
            //Mail::sendEmail();
        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }
    }
} else {
    header("Location: login.php");
}

// Get messages for specific chat
$conn = Db::getConnection();
$senderId = $_SESSION['user_id'];
$receiverId = $_SESSION['receiver_id'];

$statement = $conn->prepare("SELECT * FROM tl_chat WHERE (senderId = '" . $senderId . "' AND receiverId = '" . $receiverId . "') OR (senderId = '" . $receiverId . "' AND receiverId = '" . $senderId . "') ORDER BY created_on ASC");
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

    .message p {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        padding: 5px;
        width: auto;
        margin-bottom: 0;
    }

    .emojis {
        background-color: red;
        padding: 0;
        width: 320px;
        visibility: hidden;
        display: inline-block;
        margin-top: 0px;
    }

    .emojis li {
        list-style: none;
        display: inline;
    }

    .reaction {
        background-color: green;
        width: 50px;
        margin-top: -30px;
        display: inline-block;
        margin-top: 0px;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./css/style.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>

<body>

    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <div class="container mt-5">
        <?php if (isset($error)) : ?>
            <div class="error mr-5"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <div class="success mr-5"><?php echo $success ?></div>
        <?php endif; ?>
    </div>

    <div class="container-matches">
        <?php foreach ($scoresOfMatchedUsers as $matchedUser => $user) : ?>
            <?php if ($user['user_id'] != $_SESSION['user_id']) : ?>
                <p class="card-text">Je hebt deze kenmerken gemeen met <?php echo $user['firstName'] ?>:</p>
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
                <span><?php echo $message['senderName']; ?></span>
                <div class="message" onmouseover="showEmojis(this)" data-messageid="<?php echo $message['id'] ?>">
                    <p>
                        <?php echo $message['message']; ?>
                    </p>
                    <div class="reaction"><?php echo ($message['emoji']) ?></div>
                    <ul class="emojis">
                        <li onclick="addEmoji(this)">Hearth</li>
                        <li onclick="addEmoji(this)">Laugh</li>
                        <li onclick="addEmoji(this)">Mouth</li>
                        <li onclick="addEmoji(this)">Sad</li>
                        <li onclick="addEmoji(this)">Angry</li>
                        <li onclick="addEmoji(this)">Like</li>
                        <li onclick="addEmoji(this)">Dislike</li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <textarea id="message" name="message" class="form-control" placeholder="Type your message here..."></textarea>
            <div class="btn-group" role="group" aria-label="Basic example">
                <input type="hidden" value="<?php echo htmlspecialchars($user['firstName']) ?>" name="receiverName"></input>
                <input id="receiver" type="hidden" value="<?php echo htmlspecialchars($user['user_id']) ?>" name="receiverId"></input>
                <input id="sendMessage" type="submit" value="Send Message" name="sendMessage" class="btn btn-primary mr-3 send-message-btn"></input>
                <?php if ($haveRequestOrBuddy == 0) : ?>
                    <input type="submit" value="Be My Buddy" class="btn btn-success btn-buddy" name="buddyRequest"></input>
                <?php endif ?>
                <button class="profile-btn btn"><a href="http://localhost/files/GitHub/Buddyapp/view.profile.php?id=<?php echo $user['user_id']; ?>" class="collection__item">Profile</a></button>
            </div>
        </form>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    function addEmoji(el) {
        let clickedEmoji = el.innerHTML;
        let reaction = $(el).parent().parent().find(".reaction");
        $(reaction).text(clickedEmoji);
        let message = $(el).parent().parent();
        let id = message.data("messageid");

        $.ajax({
            url: 'ajax/saveemoji.php',
            type: 'POST',
            data: {
                emoji: clickedEmoji,
                id: id
            },
            success: function(response) {
                console.log(response);
            }
        });
    }

    function showEmojis(el) {
        $(el).find("ul").css("visibility", "visible");
    }

    $(".message").mouseleave(function() {
        $(".emojis").css("visibility", "hidden");
    });

    $("#sendMessage").on("click", function(e) {
        let chat_message = $('#message').val();

        $.ajax({
            url: 'ajax/sendMessage.php',
            type: 'POST',
            data: {
                chat_message: chat_message
            },
            success: function(response) {
                console.log(response);
                $(".display-chat").append($("<span><?php echo $message['senderName']; ?></span><div class='message' onmouseover='showEmojis(this)'><p>" + chat_message + "</p><div class='reaction'></div><ul class='emojis'><li onclick='addEmoji(this)'>Hearth</li><li onclick='addEmoji(this)'>Laugh</li><li onclick='addEmoji(this)'>Mouth</li><li onclick='addEmoji(this)'>Sad</li><li onclick='addEmoji(this)'>Angry</li><li onclick='addEmoji(this)'>Like</li><li onclick='addEmoji(this)'>Dislike</li></ul></div>"));
                $('#message').val("");
            }
        });

        e.preventDefault();
    });
</script>

</html>