<?php 

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Buddies.php");

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {

} else {
    header("Location: login.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Document</title>
</head>
<body>
    <div class="forum">
        <div class="faq">
            <nav id="navbar-example2" class="navbar navbar-light bg-light">
                <a class="navbar-brand" href="#"></a>
                <ul class="nav nav-pills">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">FAQ</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#one">one</a>
                            <a class="dropdown-item" href="#two">two</a>
                            <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#three">three</a>
                            </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mdo">Forum</a>
                    </li>
                </ul>
            </nav>
            <div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                <!-- php for each faq as question-->
                    <h4 id="one">one</h4>
                    <p>...</p>
                <!-- php for each questions as question-->
                    <h4 id="two">two</h4>
                    <p>...</p>
                    <h4 id="three">three</h4>
                    <p>...</p>
            </div>
        </div>
    </div>
</body>
</html>