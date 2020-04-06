<?php
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();

    $succes = '';

    if(isset($_POST['searchField'])){
        $searchName = UserManager::searchName();
        if(empty($_POST['searchField'])){
            $error = 'Typ a name';
        }else{
            if(!isset($_POST['searchName'])){
                    $error = 'No result';
                } else{
                    foreach($searchName as $name){
                        $succes .= '<div>' . $name['firstName'] . " ". $name['lastName'] . '</div>';
                    }
                }
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for a buddy</title>
</head>
<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>
    
    <form action="search.php" method="POST">
    <div class="container mt-5">

        <div class="form-group">
            <label for="email"><b>Name</b></label>
            <input class="form-control" type="text" name="searchField" placeholder="Name">
        </div>

        <div class="form-group">
            <input class="btn border" type="submit" value="Search for a name" name='searchName'>
        </div>

        <div class="form-group">
        <?php if(isset($error)): ?>
            <p>
                <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <?php if(isset($succes)): ?>
            <p>
                <?php echo $succes; ?>
            </p>
        <?php endif; ?>
        </div>

        <!--<div class="container mt-5">
        <table class="table">
            <tr>
                <th>First name</th>
                <th>Last name</th>
            </tr>
            <tr>
                <?php if(isset($error)): ?>
                    <p>
                        <?php echo $error; ?>
                    </p>
                <?php endif; ?>

                <td></td> 
                <td></td>
            </tr>
        </table>
        </div>-->

        <div class="form-group">
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
        <input class="btn border" type="submit" value="Search for a buddy" name='submitBuddy'>
        </div>
    </div>

    <div class="container mt-5">
    <table class="table">
        <tr>
            <th>First name</th>
            <th>Last name</th>
        </tr>
        <!--<?php 
        if(isset($_POST['submitBuddy'])){
            $mainCourseInterest = $_POST['mainCourseInterest'];
            $schoolYear = $_POST['schoolYear'];
            $sportType = $_POST['sportType'];
            $goingOutType = $_POST['goingOutType'];

            if($mainCourseInterest != "" || $schoolYear != "" || $sportType != "" || $goingOutType != ""){
            //$sportType = $_POST['sportType'];
                echo $query = "SELECT * FROM tl_user WHERE mainCourseInterest = '$mainCourseInterest' OR schoolYear = '$schoolYear' 
                OR sportType = '$sportType' OR goingOutType = '$goingOutType'";

                $data = mysqli_query($conn,$query);

                if(mysqli_num_rows($data) > 0){
                    while($row = mysqli_fetch_assoc($data)){
                        $firstName = $row['firstName'];
                        $lastName = $row['lastName'];
                        $mainCourseInterest = $row['mainCourseInterest'];
                        $schoolYear = $row['schoolYear'];
                        $sportType = $row['sportType'];
                        $goingOutType = $row['goingOutType'];
                    }
                }else{

                }
            }
        }
        ?>
        <tr>
            <td> <?php echo $firstName; ?> </td>
            <td> <?php echo $lastName; ?> </td>
        </tr>-->
    </table>
    </div>

    </form>
</body>
</html>