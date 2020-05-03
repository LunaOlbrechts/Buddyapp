<?php

spl_autoload_register();
session_start();

$id =  $_SESSION["user_id"];

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $buddy = new \src\BeMyBuddy\Buddies();
    $otherId = $_SESSION["receiver_id"];
    $haveRequestOrBuddy = \src\BeMyBuddy\Buddies::haveRequestOrBuddy($id, $otherId);

    if (isset($_POST['sendMessage']) && $_POST['sendMessage'] && !empty($_POST['message'])) {
        try {
            $message = new \src\BeMyBuddy\Chat();
            $message->setMessage($_POST['message']);
            $message->setSenderId($_SESSION['user_id']);
            $message->setSenderName($_SESSION['first_name']);
            $message->setReceiverId($_SESSION['receiver_id']);
            $message->setReceiverName($_SESSION['receiver_name']);

            $result = \src\BeMyBuddy\Chat::sendMessage($message);
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }

    if (isset($_POST["buddyRequest"]) && $_POST['buddyRequest'] && !empty($_POST['buddyRequest'])) {
        try {
            $buddy = new \src\BeMyBuddy\Buddies();
            $buddy->setSender($_SESSION['user_id']);
            $buddy->setReceiver($_SESSION['receiver_id']);
            \src\BeMyBuddy\Buddies::sendRequest($buddy);
            \src\BeMyBuddy\Mail::sendEmailBuddyRequest();
        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }
    }
} else {
    header("Location: login.php");
}

$senderId = $_SESSION['user_id'];
$receiverId = $_SESSION['receiver_id'];

//Get all messages for this chat
$messages = \src\BeMyBuddy\Chat::updateMessages($senderId, $receiverId);
//Set messages to readed on chat join
\src\BeMyBuddy\Chat::updateReaded($senderId, $receiverId);

$currentUser = \src\BeMyBuddy\UserManager::getUserFromDatabase();
$matchedUsers = \src\BeMyBuddy\UserManager::matchUsersByFiltersChat();
$scoresOfMatchedUsers = \src\BeMyBuddy\UserManager::getScoresOfMatchedUsers($currentUser, $matchedUsers);

?><!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./css/style.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buddy app | Chat</title>
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
                <span><?php echo htmlspecialchars($message['senderName']); ?></span>
                <div class="message" data-messageid="<?php echo $message['id'] ?>">
                    <p>
                        <?php echo htmlspecialchars($message['message']); ?>
                    </p>
                    <div class="reaction">
                        <?php
                        if (isset($message["emoji"])) {
                            echo htmlspecialchars($message['emoji']);
                        }
                        ?></div>
                    <ul class="emojis">
                        <li class="emoji">❤️</li>
                        <li class="emoji">😂</li>
                        <li class="emoji">😯</li>
                        <li class="emoji">😢</li>
                        <li class="emoji">😡</li>
                        <li class="emoji">👍</li>
                        <li class="emoji">👎</li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <textarea id="message" name="message" class="form-control" placeholder="Type your message here..."></textarea>
            <div class="btn-group" role="group" aria-label="Basic example">
                <input type="hidden" value="<?php echo htmlspecialchars($user['firstName']) ?>" name="receiverName"></input>
                <input id="receiver" type="hidden" value="<?php echo htmlspecialchars($user['user_id']) ?>" name="receiverId"></input>
                <input id="sendMessage" type="submit" value="Verstuur" name="sendMessage" class="btn btn-primary mr-3 send-message-btn"></input>
                <?php if ($haveRequestOrBuddy == 0) : ?>
                    <input type="submit" value="Be My Buddy" class="btn btn-success btn-buddy" name="buddyRequest"></input>
                <?php endif ?>
                <button class="profile-btn btn"><a class="profile-btn" href="view.profile.php?id=<?php echo $user['user_id']; ?>" class="collection__item">Bekijk profiel</a></button>
            </div>
        </form>
    </div>
    <?php include_once(__DIR__ . "/include/footer.inc.php"); ?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/emojiChat.js"></script>

<script>
    //Send message with AJAX
    $("#sendMessage").on("click", function(e) {
        let chat_message = $('#message').val();

        $.ajax({
            url: 'sendMessage.php',
            type: 'POST',
            data: {
                chat_message: chat_message
            },
            success: function(response) {
                console.log(response);
                $(".display-chat").append($("<span><?php echo $_SESSION["first_name"]; ?></span><div class='message'><p>" + chat_message + "</p><div class='reaction'></div><ul class='emojis'><li onclick='addEmoji(this)'>❤️</li><li onclick='addEmoji(this)'>😂</li><li onclick='addEmoji(this)'>😯</li><li onclick='addEmoji(this)'>😢</li><li onclick='addEmoji(this)'>😡</li><li onclick='addEmoji(this)'>👍</li><li onclick='addEmoji(this)'>👎</li></ul></div>"));
                $('#message').val("");
            }
        });

        e.preventDefault();
    });
</script>

</html>