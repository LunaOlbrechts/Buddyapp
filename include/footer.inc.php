<?php
include_once(__DIR__ . "/../classes/Chat.php");
include_once(__DIR__ . "/../classes/UserManager.php");

session_start();

//Check if there needs to be displayed an unread message
$receiverId = $_SESSION['user_id'];
$unreadMessages = Chat::checkForNotification($receiverId);
?>
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