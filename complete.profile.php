<?php
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();

    /*
        TODO: replace hardcoded values from the session id value 
        that is given by the login and signup feature 
    */
        $id =  $_SESSION["user_id"];

    $showError = false;

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
        // check !empty post
        if (!empty($_POST)) {
                //try catch set properties and connect to database 
                try {
                    $user = new User();
                    
                    $user->setId($id);
                    $user->setLocation($_POST['inputLocation']);
                    $user->setMainCourseInterest($_POST['mainCourseInterest']);
                    $user->setSchoolYear($_POST['schoolYear']);
                    $user->setSportType($_POST['sportType']);
                    $user->setGoingOutType($_POST['goingOutType']);
                    $user->setBuddyType($_POST['buddyType']);

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
                    <input type="text" class="form-control" name="inputLocation" placeholder="Plaats" value="<?php if(isset($_POST['inputLocation'])): echo $_POST['inputLocation'] ?><?php endif ?>">
                </div>

                <label>Opleidingsinteresse</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="mainCourseInterest" id="Frontend development" value="Frontend development" checked>
                    <label class="form-check-label" for="exampleRadios1">Frontend development</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="mainCourseInterest" id="Backend development" value="Backend development">
                    <label class="form-check-label" for="exampleRadios2">Backend development</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="mainCourseInterest" id="Web design" value="Web design">
                    <label class="form-check-label" for="exampleRadios3">Web design</label>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Opleidingsjaar</label>
                    <select class="form-control" name="schoolYear">
                        <option selected></option>
                        <option <?php if(isset($_POST['schoolYear']) && $_POST['schoolYear'] == '1 IMD'): echo "selected" ?><?php endif ?>>1 IMD</option>
                        <option <?php if(isset($_POST['schoolYear']) && $_POST['schoolYear'] == '2 IMD'): echo "selected" ?><?php endif ?>>2 IMD</option>
                        <option <?php if(isset($_POST['schoolYear']) && $_POST['schoolYear'] == '3 IMD'): echo "selected" ?><?php endif ?>>3 IMD</option>
                        <option <?php if(isset($_POST['schoolYear']) && $_POST['schoolYear'] == 'Aangepast programma'): echo "selected" ?><?php endif ?>>Aangepast programma</option>
                    </select>
                </div>
                
                <div class="form-group">
                <label class="form-title">Buddy</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="lookingForABuddy" name="buddyType" value="lookingForABuddy" checked>
                    <label class="form-check-label" for="lookingForABuddy">Ik ben op zoek naar een buddy</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="wantToBeABuddy" name="buddyType" value="wantToBeABuddy">
                    <label class="form-check-label" for="isABuddy">Ik wil een buddy zijn</label>
                </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Welk type sporter ben jij?</label>
                    <select class="form-control" name="sportType">
                        <option selected></option>
                        <option <?php if(isset($_POST['sportType']) && $_POST['sportType'] == 'Waterrat'): echo "selected" ?><?php endif ?>>Waterrat</option>
                        <option <?php if(isset($_POST['sportType']) && $_POST['sportType'] == 'Krachtpatser'): echo "selected" ?><?php endif ?>>Krachtpatser</option>
                        <option <?php if(isset($_POST['sportType']) && $_POST['sportType'] == 'Uithoudingsvermogen'): echo "selected" ?><?php endif ?>>Uithoudingsvermogen</option>
                        <option <?php if(isset($_POST['sportType']) && $_POST['sportType'] == 'Teamplayer'): echo "selected" ?><?php endif ?>>Teamplayer</option>
                        <option <?php if(isset($_POST['sportType']) && $_POST['sportType'] == 'Zetelhanger'): echo "selected" ?><?php endif ?>>Zetelhanger</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Welk uitgaanstype ben jij?</label>
                    <select class="form-control" name="goingOutType">
                        <option selected></option>
                        <option <?php if(isset($_POST['goingOutType']) && $_POST['goingOutType'] == 'Party animal'): echo "selected" ?><?php endif ?>>Party animal</option>
                        <option <?php if(isset($_POST['goingOutType']) && $_POST['goingOutType'] == 'Gezellig samen met vrienden'): echo "selected" ?><?php endif ?>>Gezellig samen met vrienden</option>
                        <option <?php if(isset($_POST['goingOutType']) && $_POST['goingOutType'] == '>Home sweet home'): echo "selected" ?><?php endif ?>>Home sweet home</option>
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