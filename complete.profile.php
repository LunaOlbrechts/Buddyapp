<?php
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();

    // TODO: replace hardcoded values
    $_SESSION["logged_in"] = true;
    $_SESSION["user_id"] = 1;
    $id =  $_SESSION["user_id"];

    $showError = false;

    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
        // check !empty post
        if(!empty($_POST) ){
                //conn database 
                try{
                    $user = new User();

                    $user->setLocation($_POST['inputLocation']);
                    $user->setSchoolYear($_POST['schoolYear']);
                    $user->setSportType($_POST['sportType']);
                    $user->setId($id);

                    UserManager::saveCompletedProfile($user);

                    $successMessage = "Your profile is complete";
                }
                catch(\Throwable $th){
                    $error = $th->getMessage();
                }
        }
    }
    else{
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="css" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Buddy app |Profile</title>
</head>
<body>
    <?php include_once("include/nav.inc.php"); ?>

    <div class="buddyProfile">
        <div class="container">
            <form method="POST" class="form">
            <h4 class="title-complete-profile">Vervolledig jouw profiel</h4>
                <?php if(isset($error)):?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif ?>
                <?php if(!isset($successMessage)):?>
                <div class="form-group">
                <p class="form-title">Plaats</p>
                    <input type="text" class="form-control" name="inputLocation" placeholder="Plaats">
                </div>

                <div class="form-group">
                    <div class="interests">
                        <p class="form-title">Opleiding interesses</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="inputBackendDevelopment" value="inputBackendDevelopment">
                            <label class="form-check-label" for="inputBackendDevelopment">backend development</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="inputFrontendDevelopment" value="inputFrontendDevelopment">
                            <label class="form-check-label" for="inputFrontendDevelopment">frontend development</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="input3dDesign" value="input3dDesign">
                            <label class="form-check-label" for="input3dDesign">3D design</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="inputWebDesign" value="inputWebDesign">
                            <label class="form-check-label" for="inputWebDesign">Web design</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Opleidingsjaar</label>
                    <select class="form-control" name="schoolYear">
                    <option>1 IMD</option>
                    <option>2 IMD</option>
                    <option>3 IMD</option>
                    <option>Aangepast programma</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Welk type sporter ben jij?</label>
                    <select class="form-control" name="sportType">
                    <option>Waterrat</option>
                    <option>Krachtpatser</option>
                    <option>Uithoudingsvermogen</option>
                    <option>Teamplayer</option>
                    <option>Zetelhanger</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="pushnotification">
                        <p class="form-title">Pushnotifications</p>
                        <div class="form-group custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="switchPushnotification">
                            <label class="custom-control-label" for="switchPushnotification">Inschakelen</label>
                        </div>
                    </div>
                </div>

                <div class="btn-submit">
                    <button class="btn btn-primary" id="submit" type="submit">Submit form</button>
                </div>
                <?php endif?>
                <?php if(isset($successMessage)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $successMessage; ?>
                </div>
                <?php endif ?>
            </form>
        </div>
    </div>
</body>
</html>