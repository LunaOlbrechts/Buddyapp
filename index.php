<?php
    session_start();
    
    $id =  $_SESSION["user_id"];

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {

    } 
    else{
        header("Location: login.php");
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php include_once("include/nav.inc.php"); ?>
    <h1 class="col-md-4" >Welkom!</h1>
</body>
</html>