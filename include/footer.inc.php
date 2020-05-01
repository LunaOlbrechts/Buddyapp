<?php
include_once(__DIR__ . "/../classes/Chat.php");
include_once(__DIR__ . "/../classes/UserManager.php");

//Check if there needs to be displayed an unread message
$receiverId = $_SESSION['user_id'];
$unreadMessages = Chat::checkForNotification($receiverId);
?>
<style>
    .newMessages{
        width: auto;
        background-color: #7AD3BB;
        position: fixed;
        bottom: 0;
        right: 100px;
        color: white;
    }

    .newMessages p{
        padding-left: 20px;
    }

    .newMessages p:first-of-type{
        font-weight: 500;
        background-color: #327374;
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>
<footer>
    <div class="newMessages">
        <!-- For each user that you have unread messages from !-->
        <?php foreach ($unreadMessages as $unreadMessage) {
            //Get user data en show name
            $id = $unreadMessage['senderId'];
            $userdata = UserManager::getUserFromDatabaseById($id)
            ?>
            <?php foreach ($userdata as $data): ?>
                <p>Nieuwe berichten van:</p>
                <p><?php echo htmlspecialchars($data['firstName']) . " " . htmlspecialchars($data['lastName'])?></p>
            <?php endforeach ?>
        <?php } ?>
    </div>
</footer>

</html>