<?php

include_once(__DIR__ . "/classes/SearchBuddy.php");

session_start();

$succes1 = '';
$succes2 = '';

// Search for name in db 
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if (isset($_GET['searchName'])) {
        $searchField = $_GET['searchField'];
        $searchName = SearchBuddy::searchName($searchField);

        if (empty($_GET['searchField'])) {
            $error = "Vul een naam in";
        } elseif (count($searchName) > 0) {
            foreach ($searchName as $name) {
                $succes1 .= '<a href="view.profile.php?id=' . htmlspecialchars($name['id']) . '" >' . '<div>' . htmlspecialchars($name['firstName']) . " " . htmlspecialchars($name['lastName']) . '</div>' . '</a>';
            }
        } else {
            $error = "Geen resultaten";
        }
    }
} else {
    header("Location: login.php");
}

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if (isset($_GET['searchBuddy'])) {
        $mainCourseInterest = $_GET['mainCourseInterest'];
        $schoolYear = $_GET['schoolYear'];
        $sportType = $_GET['sportType'];
        $goingOutType = $_GET['goingOutType'];

        $searchBuddy = SearchBuddy::searchBuddyByFilter($mainCourseInterest, $schoolYear, $sportType, $goingOutType);

        if (
            empty($_GET['mainCourseInterest']) && empty($_GET['schoolYear'])
            && empty($_GET['sportType']) && empty($_GET['goingOutType'])
        ) {
            $error2 = "Duid een filter aan";
        } elseif (count($searchBuddy) > 0) {
            foreach ($searchBuddy as $name) {
                $succes2 .= '<a href="view.profile.php?id=' . htmlspecialchars($name['id']) . '" >' . '<div>' . htmlspecialchars($name['firstName']) . " " . htmlspecialchars($name['lastName']) . '</div>' . '</a>';
            }
        } else {
            $error2 = "Geen resultaten";
        }
    }
} else {
    header("Location: login.php");
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buddy app | Een buddy zoeken</title>
</head>
<body>

    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <form method="GET" action="">
        <div class="container mt-5">
            <h3>Zoek hier naar een buddy</h3>

            <div class="form-group">
                <label for="name"><b>Naam</b></label>
                <input class="form-control" type="text" name="searchField" placeholder="Naam" id="searchName" autocomplete="off">
                <div id="suggesstionBox"></div>
            </div>

            <div class="form-group">
                <input class="btn border search-name-btn" type="submit" value="Naam zoeken" name='searchName'>
            </div>
    </form>

    <div class="form-group">
        <?php if (isset($error)) : ?>
            <p>
                <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <?php if (isset($succes1)) : ?>
            <p>
                <?php echo $succes1; ?>
            </p>
        <?php endif; ?>
    </div>

    <form method="GET" action="">
        <div class="form-group course-interests">
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
            <label class="title"><b>Opleidingsjaar</b></label>
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
            <label class="title"><b>Type sporter</b></label>
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
            <label class="title"><b>Uitgaanstype</b></label>
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
            <input class="btn border search-btn" type="submit" value="Buddy zoeken" name='searchBuddy'>
        </div>
    </form>

    <div class="form-group">
        <?php if (isset($error2)) : ?>
            <p>
                <?php echo $error2; ?>
            </p>
        <?php endif; ?>

        <?php if (isset($succes2)) : ?>
            <p>
                <?php echo $succes2; ?>
            </p>
        <?php endif; ?>
    </div>
    <?php include_once(__DIR__ . "/include/footer.inc.php"); ?>

    <script src="js/autocomplete.js"></script>

</body>

</html>