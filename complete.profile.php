<?php

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
                <div class="alert alert-danger" role="alert">
                    A simple danger alert—check it out!
                </div>

                <div class="form-group">
                <p class="form-title">Plaats</p>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Plaats">
                </div>

                <div class="form-group">
                    <div class="interests">
                        <p class="form-title">Opleiding interesses</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inputBackendDevelopment" value="inputBackendDevelopment">
                            <label class="form-check-label" for="inputBackendDevelopment">backend development</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inputFrontendDevelopment" value="inputFrontendDevelopment">
                            <label class="form-check-label" for="inputFrontendDevelopment">frontend development</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="input3dDesign" value="input3dDesign">
                            <label class="form-check-label" for="input3dDesign">3D design</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inputWebDesign" value="inputWebDesign">
                            <label class="form-check-label" for="inputWebDesign">Web design</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="interests">
                        <p class="form-title">Opleidingsjaar</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="input1Imd" value="input1Imd">
                            <label class="form-check-label" for="input1Imd">1 IMD</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="input2Imd" value="input2Imd">
                            <label class="form-check-label" for="input2Imd">2 IMD</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="input3Imd" value="input3Imd">
                            <label class="form-check-label" for="input3Imd">3 IMD</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inputAangepastProgramma" value="inputAangepastProgramma">
                            <label class="form-check-label" for="inputAangepastProgramma">Aangepast programma</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="form-title">Welk type sporter ben jij?</label>
                    <select class="form-control" id="exampleFormControlSelect1">
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
                
                <button class="btn btn-primary" id="submit" type="submit">Submit form</button>
            </form>
        </div>
    </div>
</body>
</html>