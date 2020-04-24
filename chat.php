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
    if (isset($_POST['sendMessage']) && $_POST['sendMessage'] && !empty($_POST['message'])) {
        try {
            $message = new Chat();
            $message->setMessage($_POST['message']);
            $message->setSenderId($_SESSION['user_id']);
            $message->setSenderName($_SESSION['first_name']);
            $message->setRecieverId($_SESSION['reciever_id']);
            $message->setRecieverName( $_SESSION['reciever_name']);
            var_dump($_SESSION);
            
            Chat::sendMessage($message);

        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }
    if (isset($_POST["buddyReques"]) && $_POST['buddyRequest'] && !empty($_POST['buddyRequest'])) {
        try {
            $buddy = new Buddies();
            $buddy->setSender($_SESSION['user_id']);
            $buddy->setReciever($_SESSION['reciever_id']);
            Buddies::sendRequest($buddy);
            Mail::sendEmail();
            echo $result;
            
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
$recieverId = $_SESSION['reciever_id'];

$statement = $conn->prepare("SELECT * FROM tl_chat WHERE (senderId = '" . $senderId . "' AND receiverId = '" . $recieverId . "') OR (senderId = '" . $recieverId . "' AND receiverId = '" . $senderId . "') ORDER BY created_on ASC");
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>

<body>
    
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <div class="container mt-5">
    <?php if(isset($error)): ?>
                <div class="error mr-5"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

            <?php if(isset($success)): ?>
                    <div class="success mr-5"><?php echo $success ?></div>
    <?php endif; ?> 
    </div>
    
    <div class="container">
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
                    <div class="reaction"><?php $emoji = $message['emoji'];
                                            switch ($emoji) {
                                                case 0:
                                                    echo "";
                                                    break;
                                                case 1:
                                                    echo "Hearth";
                                                    break;
                                                case 2:
                                                    echo "Laugh";
                                                    break;
                                                case 3:
                                                    echo "Mouth";
                                                    break;
                                                case 4:
                                                    echo "Sad";
                                                    break;
                                                case 5:
                                                    echo "Angry";
                                                    break;
                                                case 6:
                                                    echo "Like";
                                                    break;
                                                case 7:
                                                    echo "Dislike";
                                                    break;
                                            }
                                            ?></div>
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
            <textarea name="message" class="form-control" placeholder="Type your message here..."></textarea>
            <div class="btn-group" role="group" aria-label="Basic example">
            <input type="hidden" value="<?php echo htmlspecialchars($user['firstName']) ?>" name="recieverName"></input>
            <input type="hidden" value="<?php echo htmlspecialchars($user['user_id']) ?>" name="recieverId"></input>
                <input type="submit" value="Send Message" name="sendMessage" class="btn btn-primary mr-3"></input>
                <input type="submit" value="Be My Buddy" class="btn btn-success" name="buddyRequest"></input>
                <button><a href="http://localhost/files/GitHub/Buddyapp/view.profile.php?id=<?php echo $user['user_id']; ?>" class="collection__item">Profile</a></button>
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

        let formData = new FormData();

        formData.append("emoji", clickedEmoji);
        formData.append("id", id);

        fetch('/ajax/saveemoji.php', {
                method: 'PUT',
                body: formData
            })
            .then((response) => response.json())
            .then((result) => {
                console.log('Success:', result);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    function showEmojis(el) {
        $(el).find("ul").css("visibility", "visible");
    }

    $(".message").mouseleave(function() {
        $(".emojis").css("visibility", "hidden");
    });
</script>

</html>