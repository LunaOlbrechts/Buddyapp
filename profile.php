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
        <div class="form container">
            <form method="POST">
            <h4 class="title-complete-profile">Complete your profile</h4>

                <div class="form-group">
                <h5>Location</h5>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Adress">
                </div>

                <div class="form-group">
                    <div class="interests">
                        <h5>Working interests</h5>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="backend_development">
                            <label class="form-check-label" for="inlineCheckbox1">backend development</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="frontend_development">
                            <label class="form-check-label" for="inlineCheckbox2">frontend development</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="3d_design">
                            <label class="form-check-label" for="inlineCheckbox3">3D design</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="web_design">
                            <label class="form-check-label" for="inlineCheckbox4">Web design</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="interests">
                        <h5>Opleidingsjaar</h5>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="1Imd" value="1Imd">
                            <label class="form-check-label" for="1Imd">1 IMD</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="2Imd" value="2Imd">
                            <label class="form-check-label" for="2Imd">2 IMD</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="3Imd" value="3Imd">
                            <label class="form-check-label" for="3Imd">3 IMD</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="aangepastProgramma" value="aangepastProgramma">
                            <label class="form-check-label" for="aangepastProgramma">Aangepast programma</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="pushnotification">
                        <h5>Pushnotifications</h5>
                        <div class="form-group custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1">Pushnotifications on</label>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</body>
</html>