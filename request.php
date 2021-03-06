<?php

include_once(__DIR__ . "/classes/Buddies.php");

session_start();

$id =  $_SESSION["user_id"];

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $buddy = new Buddies();
    $buddies = Buddies::findRequest();
    $deny = 0;

    if (isset($_POST['accept']) && ($_POST['accept'])) {
        try {
            $_SESSION['requested'] = $_POST['requested'];
        } catch (\Throwable $th) {
        }
    }

    // ACCEPT BUDDY REQUEST
    if (isset($_POST['accept']) && ($_POST['accept'])) {
        $buddy = new Buddies();
        Buddies::makeBuddy();
        header("Location: index.php");
    }

    // DENY BUDDY REQUEST -> Give reason field
    if (isset($_POST['deny']) && ($_POST['deny'])) {
        $deny = true;
        $_SESSION['requested'] = $_POST['requested'];
    }    
    

    // DENY BUDDY REQUEST WITH REASON
    if (isset($_POST['goReason']) && !empty($_POST['messageDeny'])) {
        $denied = new Buddies();
        $denied->setSender($_SESSION['user_id']);
        $denied->setReceiver($_SESSION['requested']);
        $denied->setDenyMessage(htmlspecialchars($_POST['messageDeny']));
        Buddies::denyMessage($denied);
        header("Location: index.php");
    }

    // DENY BUDDY REQUEST WITH NO REASON
    if (isset($_POST['goNoReason']) && $_POST['goNoReason']) {
        $denied = new Buddies();
        $denied->setSender($_SESSION['user_id']);
        $denied->setReceiver($_SESSION['requested']);
        Buddies::denyNoMessage($denied);
        header("Location: index.php");
    }   
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Buddy app | Verzoek</title>
</head>
<body>

    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <div class="card-group container mt-5 container-request">

        <div class="card card-request shadow  p-3 mb-5 bg-white rounded">
            <?php foreach ($buddies as $buddy) :  ?>
                <?php if($deny == 0) : ?>
                    <?php echo htmlspecialchars($buddy["firstName"]) . " wil jouw buddy zijn!"; ?>
                    <form method="GET" class="mx-auto"> 

                    <div class="btn-group" role="group" > 
                        <button class="profile-btn btn"><a class="profile-btn" href="view.profile.php?id=<?php echo $buddy['sender']; ?>" class="collection__item">Bekijk profiel</a>
                    </div>

                    </form>

                    <form method="POST" class="mx-auto">
                        <input type="hidden" value="<?php echo htmlspecialchars($buddy['sender']) ?>" name="requested">

                        <div class="btn-group" role="group">
                            <input type="submit" value="Accepteer" name="accept" class="btn btn-success mr-3 accept"></input>
                            <input type="submit" value="Weiger" name="deny" class="btn btn-danger mr-3 deny"></input>
                        </div>

                    </form>
                <?php endif ?>

                <?php if ($deny == true) : ?>
                    <form method="POST">
                        <input type="text" name="messageDeny" class="form-control" placeholder="Geef een reden waarom je deze buddy verzoek geweigerd hebt."></input>
                    
                        <div class="btn-group" role="group" >        
                                <input type="submit" value="Stuur reden" name="goReason" class="btn btn-info mr-3 send-reason"></input>
                                <input type="submit" value="Geen reden" name="goNoReason" class="btn btn-info mr-3 no-reason"></input>
                        </div>
                    </form>
                <?php endif ?>
            <?php endforeach ?>

        </div>
    </div>

    <?php include_once(__DIR__ . "/include/footer.inc.php"); ?>

</body>
</html>