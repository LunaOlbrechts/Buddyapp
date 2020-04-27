<?php
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");

session_start();

$succes1 = '';
$succes2 = '';

$searchField = $_POST['searchField'];

// Search for name in db 
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if($_POST['searchName']){
        $searchName = UserManager::searchName($user);
        if (empty($_POST['searchField'])){
            $error1 = "Vul een naam in";
        }

        elseif (count($searchName) > 0) {
            foreach ($searchName as $name) {
                $succes1 .= '<div>' . $name['firstName'] . " " . $name['lastName'] . '</div>';
            }
        } else{
            $error2 = "Geen resultaten";
        }
    }
} else {
    header("Location: login.php");
}


if ($_POST['searchBuddy']) {
    $searchBuddy = UserManager::searchBuddyByFilter();
    /*$_SESSION['mainCourseInterest'] = $_POST['mainCourseInterest'];
    $_SESSION['schoolYear'] = $_POST['schoolYear'];
    $_SESSION['sportType'] = $_POST['sportType'];
    $_SESSION['goingOutType'] = $_POST['goingOutType'];*/

    if (!empty($_POST['mainCourseInterest']) || !empty($_POST['schoolYear']) || !empty($_POST['sportType']) || !empty($_POST['goingOutType'])) {
        foreach ($searchBuddy as $name) {
            $succes2 .= '<div>' . $name['firstName'] . " " . $name['lastName'] . '</div>';
        }
    } else{
        $error3 = 'Check a filter';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for a buddy</title>
</head>

<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <form method="post" action="">
        <div class="container mt-5">
            <h1 class="col-md">Zoek hier naar een buddy</h1>
            <p>Zoek naar een buddy via de zoekbalk of via de filter</p>
            <h3>Buddy zoeken via zoekbalk</h3>
            <div class="form-group">
                <label for="name"><b>Name</b></label>
                <input class="form-control" type="text" name="searchField" placeholder="Name" id="name">
            </div>

            <div class="form-group">
                <input class="btn border" type="submit" value="Search for a name" name='searchName'>
            </div>
    </form>

    <div class="form-group">
        <?php if (isset($error1)) : ?>
            <p>
                <?php echo $error1; ?>
            </p>
        <?php endif; ?>

        <?php if (isset($error2)) : ?>
            <p>
                <?php echo $error2; ?>
            </p>
        <?php endif; ?>

        <?php if (isset($succes1)) : ?>
            <p>
                <?php echo $succes1; ?>
            </p>
        <?php endif; ?>
    </div>


    <form method="post" action="">
        <div class="form-group">
            <h3>Buddy zoeken via filter</h3>
            <label><b>Opleidingsinteresses</b></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="mainCourseInterest" id="Frontend development" value="Frontend development">
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
        </div>

        <div class="form-group">
            <label><b>Opleidingsjaar</b></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="schoolYear" id="1 IMD" value="1 IMD">
                <label class="form-check-label" for="exampleRadios1">1 IMD</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="schoolYear" id="2 IMD" value="2 IMD">
                <label class="form-check-label" for="exampleRadios2">2 IMD</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="schoolYear" id="3 IMD" value="3 IMD">
                <label class="form-check-label" for="exampleRadios3">3 IMD</label>
            </div>
        </div>

        <div class="form-group">
            <label><b>Type sporter</b></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sportType" id="Waterrat" value="Waterrat">
                <label class="form-check-label" for="exampleRadios1">Waterrat</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sportType" id="Krachtpatser" value="Krachtpatser">
                <label class="form-check-label" for="exampleRadios2">Krachtpatser</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sportType" id="Uithoudingsvermogen" value="Uithoudingsvermogen">
                <label class="form-check-label" for="exampleRadios3">Uithoudingsvermogen</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sportType" id="Teamplayer" value="Teamplayer">
                <label class="form-check-label" for="exampleRadios2">Teamplayer</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="sportType" id="Zetelhanger" value="Zetelhanger">
                <label class="form-check-label" for="exampleRadios3">Zetelhanger</label>
            </div>
        </div>

        <div class="form-group">
            <label><b>Uitgaanstype</b></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="goingOutType" id="Party animal" value="Party animal">
                <label class="form-check-label" for="exampleRadios1">Party animal</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="goingOutType" id="Gezellig samen met vrienden" value="Gezellig samen met vrienden">
                <label class="form-check-label" for="exampleRadios2">Gezellig samen met vrienden</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="goingOutType" id="Home sweet home" value="Home sweet home">
                <label class="form-check-label" for="exampleRadios3">Home sweet home</label>
            </div>
        </div>

        <div>
            <input class="btn border" type="submit" value="Search for a buddy" name='searchBuddy'>
        </div>
    </form>

    <div class="form-group">
        <?php if (isset($error3)) : ?>
            <p>
                <?php echo $error3; ?>
            </p>
        <?php endif; ?>

        <?php if (isset($succes2)) : ?>
            <p>
                <?php echo $succes2; ?>
            </p>
        <?php endif; ?>
    </div>

</body>

</html>