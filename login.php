<?php
    include_once(__DIR__ . "/classes/User.php");

// toon een foutmelding indien inloggen niet gelukt is (zie screenshot)


// valideer al wat kan mislopen in dit formulier via PHP


// uitloggen is mogelijk


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Buddy app | Login</title>
</head>
<body>
    <form action="" method="post">
        <div>
            <label for="email">E-mail:</label><br>
            <input type="text" id='name' name='name'><br>
        </div>
        <div>
            <label for="password">Password:</label><br>
            <input type="password" id='password' name='password'><br>
        </div>

        <div>
        <br><br>
            <input type="submit" value="Log in"> 
        </div>
    </form>

</body>
</html>