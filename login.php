<?php
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");

// make form log in user
// check ih 
// if user doesn't exist in db => message: "can't login user" of "mag niet leeg zijn" "geen geldig email"
// if user exists in db => go to profile.php of that user
// user presses button "log out" => then go back to login.php

// toon een foutmelding indien inloggen niet gelukt is (zie screenshot)
// valideer al wat kan mislopen in dit formulier via PHP
// uitloggen is mogelijk

// if form was submit
if (!empty($_POST)) {
    $email =  $_POST['email'];
    $password =  $_POST['password'];
    // check if required fields are not empty
    if (!empty($email) && !empty($password)) {
        try {
            $user = new User();
            $user->setPasswordForVerification($_POST['password']);
            $user->setEmail($_POST['email']);
            
            UserManager::logIn($user);
            
            $error = "Logged in!";
        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }

    } elseif (empty($email) && empty($password)) {
        $error = "Email & password are required";
    } elseif (empty($email)) {
        $error = "Email is required";
    } elseif (empty($password)) {
        $error = "Password is required";
    }
}


?>
<!DOCTYPE html>
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
        <div class="container mt-5">
            <h2 form__title>Sign In</h2>

            <?php if (isset($error)) : ?>
                <div class="mr-5">
                    <p>
                        <?php echo $error; ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input class="form-control" type="text" id='email' name='email' placeholder="Enter e-mail">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="password" id='password' name='password' placeholder="Enter password">
            </div>

            <div class="form-group">
                <input class="btn border" type="submit" value="Log in" name='submit'>
            </div>
        </div>
    </form>

</body>

</html>