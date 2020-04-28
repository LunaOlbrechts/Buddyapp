<?php
session_start();
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Buddies.php");
include_once(__DIR__ . "/classes/Chat.php");


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
        $messageForDeny = new Buddies();
        $messageForDeny->setDenyMessage(htmlspecialchars($_POST['messageDeny']));
        Buddies::denyMessage($messageForDeny);
        header("Location: index.php");
    }

    // DENY BUDDY REQUEST WITH NO REASON
    if (isset($_POST['goNoReason']) && $_POST['goNoReason']) {
        Buddies::denyNoMessage();
        header("Location: index.php");
    }   

}
  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Request</title>
</head>

<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>


    <div class="card-group container mt-5">

        <div class="card">
            <?php foreach ($buddies as $buddy) :  ?>
                <?php if($deny == 0) : ?>
                    <?php echo htmlspecialchars($buddy["firstName"]) . " wants to be your buddy!"; ?>
                    <form method="GET" class="mx-auto"> 


                    <div class="btn-group" role="group" > 
                        <button><a href="http://localhost/files/GitHub/Buddyapp/view.profile.php?id=<?php echo $buddy['sender']; ?>" class="collection__item">Profile</a>
                    </div>

                    </form>

                    <form method="POST" class="mx-auto">
                        <input type="hidden" value="<?php echo htmlspecialchars($buddy['sender']) ?>" name="requested">


                        <div class="btn-group" role="group">
                            <input type="submit" value="Accept" name="accept" class="btn btn-success mr-3"></input>
                            <input type="submit" value="Deny" name="deny" class="btn btn-danger mr-3"></input>
                        </div>

                    </form>
                <?php endif ?>

                <?php if ($deny == true) : ?>
                    <form method="POST">
                        <textarea name="messageDeny" class="form-control" placeholder="Give a reason why you denied this buddy request."></textarea>
                    
                        <div class="btn-group" role="group" >        
                                <input type="submit" value="Send reason" name="goReason" class="btn btn-info mr-3"></input>
                                <input type="submit" value="No reason" name="goNoReason" class="btn btn-info mr-3"></input>
                        </div>
                    </form>
                <?php endif ?>
            <?php endforeach ?>


        </div>

    </div>

</body>

</html>