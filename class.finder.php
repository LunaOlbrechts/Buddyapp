<?php
     include_once(__CLASS__ ."classes/User.php");
     include_once(__CLASS__ ."classes/UserManager.php");

     session_start();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <form method="POST" action="">
        <div class="container mt-5">
            <h1 class="col-md-5">Lokaal vinder</h1>
            <p>Geef hieronder een lokaal in om te zoeken naar een beschrijving</p>
            <div class="form-group">
                <label for="class"><b>Geef een lokaal in</b></label>
                <input class="form-control" type="text" name="searchField" placeholder="Lokaal">
            </div>

            <div class="form-group">
                <input class="btn border" type="submit" value="Zoek" name='searchClass'>
            </div>
        </div>
    </form>

</body>
</html>