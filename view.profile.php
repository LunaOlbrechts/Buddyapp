<?php
session_start();
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Buddies.php");


    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {       
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
          } else {
            die("An ID is missing. 🙄");
          }
        
        
        if (isset($_POST['chat']) && ($_POST['chat'])) {
            try {
                $_SESSION['sender'] = $_POST['request'];
                header("Location: chat.php");
            } catch (\Throwable $th) {
                $profileInformationError = $th->getMessage();
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <div class="d-flex justify-content-center">
        <?php foreach($user as $users) : ?>
            <div class="card">
                <h2 class="card-title">Profile of <?php echo ($users['firstName']) . " " . ($users['lastName']) ?></h2>
                <p class="card-text">Woonplaats: <?php echo ($users['city']) ?></p>
                <p class="card-text">opleidingsjaar: <?php echo ($users['schoolYear']) ?></p>
                <p class="card-text">opleidingsintresse: <?php echo ($users['mainCourseInterest']) ?></p>
                <p class="card-text">Sport type: <?php echo ($users['sportType']) ?></p>
                <p class="card-text">Uitgaanstype: <?php echo ($users['goingOutType']) ?></p>
                <p class="card-text">Buddy: <?php echo ($users['buddyType']) ?></p>
            </div>
            <form method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo htmlspecialchars($user['sender']) ?>" name="sender"></input>
            <div class="btn-group" role="group" >        
                <input type="submit" value="Chat" name="chat" class="btn btn-primary mr-3"></input> 
            </div> 
            </form>
        <?php endforeach ?>    
    </div>


</body>
</html>