<?php
session_start();
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Chat.php");

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if ($_POST['sendMessage'] && !empty($_POST['message'])) {
        try {
            $message = new Chat();
            $message->setMessage($_POST['message']);
            $message->setName($_SESSION["firstName"]);
            Chat::sendMessage($message);
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    }
} else {
    header("Location: login.php");
}

$conn = Db::getConnection();
$statement = $conn->prepare("select * from tl_chat");
$statement->execute();
$messages = $statement->fetchAll(PDO::FETCH_ASSOC);
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
        height: 300px;
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
    <title>Document</title>
</head>

<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <div class="container">
        <div class="display-chat">
            <?php foreach ($messages as $message) : ?>
                <span><?php echo $message['name']; ?></span>
                <div class="message">
                    <p>
                        <?php echo $message['message']; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <textarea name="message" class="form-control" placeholder="Type your message here..."></textarea>
            <input type="submit" value="Send Message" name="sendMessage" class="btn btn-primary"></input>
        </form>
    </div>
</body>

</html>