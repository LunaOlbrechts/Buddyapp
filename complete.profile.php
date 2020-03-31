<?php
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();

    /*
        TODO: replace hardcoded values from the session id value 
        that is given by the login and signup feature 
    */
       $_SESSION["logged_in"] = true;
       $_SESSION["user_id"] = 3;
    $id =  $_SESSION["user_id"];

    $showError = false;

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
        // check !empty post
        if (!empty($_POST) ) {
                //try catch set properties and connect to database 
                try {
                    $user = new User();
                    
                    $user->setId($id);
                    $user->setLocation($_POST['inputLocation']);
                    $user->setMainCourseInterest($_POST['mainCourseInterest']);
                    $user->setSchoolYear($_POST['schoolYear']);
                    $user->setSportType($_POST['sportType']);
                    $user->setGoingOutType($_POST['goingOutType']);

                    UserManager::saveCompletedProfile($user);

                    $successMessage = "Your profile is complete";

                    header("Location: index.php");
                }
                catch (\Throwable $th) {
                    $error = $th->getMessage();
                }
        }
    }
    else {
        header("Location: login.php");
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
                        <label for="exampleFormControlSelect1" class="form-title">Opleidingsinteresse</label>
                        <select class="form-control" name="mainCourseInterest">
                            <option selected>kies een optie</option>
                            <option>Frontend development</option>
                            <option>Backend development</option>
                            <option>Web design</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Opleidingsjaar</label>
                    <select class="form-control" name="schoolYear">
                    <option selected>kies een optie</option>
                    <option>1 IMD</option>
                    <option>2 IMD</option>
                    <option>3 IMD</option>
                    <option>Aangepast programma</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Welk type sporter ben jij?</label>
                    <select class="form-control" name="sportType">
                    <option selected>kies een optie</option>
                    <option>Waterrat</option>
                    <option>Krachtpatser</option>
                    <option>Uithoudingsvermogen</option>
                    <option>Teamplayer</option>
                    <option>Zetelhanger</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Welk type uitgaanstype ben jij?</label>
                    <select class="form-control" name="goingOutType">
                    <option selected>kies een optie</option>
                    <option>Party animal</option>
                    <option>Gezellig samen met vrienden</option>
                    <option>Home sweet home</option>
                    </select>
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