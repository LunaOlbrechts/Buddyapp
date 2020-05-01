<?php

$conn = Db::getConnection();
$receiverId = $_SESSION['user_id'];

$statement = $conn->prepare("SELECT senderId FROM tl_chat WHERE (receiverid = '" . $receiverId . "' AND readed = 0) GROUP BY senderName");
$statement->execute();
$unreadMessages = $statement->fetchAll(PDO::FETCH_ASSOC);

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
        <?php foreach ($unreadMessages as $unreadMessage) {
            $userId = $unreadMessage['senderId'];
            $statement = $conn->prepare("SELECT * FROM tl_user WHERE (id = '" . $userId . "')");
            $statement->execute();
            $userdata = $statement->fetchAll(PDO::FETCH_ASSOC); ?>
            <?php foreach ($userdata as $data): ?>
                <p>Nieuwe berichten van:</p>
                <p><?php echo htmlspecialchars($data['firstName']) . " " . htmlspecialchars($data['lastName'])?></p>
            <?php endforeach ?>
        <?php } ?>
    </div>
</footer>

</html>