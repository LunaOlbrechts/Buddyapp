<?php
    include_once(__DIR__ . "/classes/User.php");

    // make form log in user
    // check ih 
    // if user doesn't exist in db => message: "can't login user" of "mag niet leeg zijn" "geen geldig email"
    // if user exists in db => go to profile.php of that user
    // user presses button "log out" => then go back to login.php

    // toon een foutmelding indien inloggen niet gelukt is (zie screenshot)
    // valideer al wat kan mislopen in dit formulier via PHP
    // uitloggen is mogelijk

    // connect to db 
    $conn = new PDO("mysql:host=db;dbname=buddy_app","root","");

    // get values from form
    $email = $_POST['email'];
    $password = $_POST['password'];

    session_start();

    if (isset($_POST)){
        $email = mysqli_real_escape_string($conn,$email);
        $password = mysqli_real_escape_string($conn,$password);

    // query
    $statement = $conn->prepare("insert into tl_user (email, password)");
    $sql = "select * from 'tl_user' where email = '$email' && password = '" .md5($password)."'";
    
    $result = mysqli_query($conn,$sql);
    $rows = mysqli_num_rows($sql);
    if($rows == 1){
        $_SESSION['email'] = $email;
        echo header("Welcome");
    } else{
        echo header("Username/ password in incorrect");
    } 

    }

    // if form was submit
	if( !empty($_POST) ) {
    // check if required fields are not empty
        $email =  $_POST ['email'];
        $password =  $_POST ['password'];

        if( !empty($email) && !empty($password) ){
            // check if email & password match
            if (canLogin($email, $password)) {
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $password;
            } else{
        header("Can't log you in");
    } 
    }else{
        header("You need to fill in the form");
    }


    }
    
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
        <div class="container mt-5">
        <h2 form__title>Sign In</h2>

        <div class="form-group">
            <label for="email">E-mail:</label>
            <input class="form-control" type="text" id='email' name='email' placeholder="Enter e-mail">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" type="password" id='password' name='password' placeholder="Enter password">
        </div>

        <div class="form-group">
            <input class="btn border" type="submit" name="submit" value="Log in"> 
        </div>
        </div>
    </form>

</body>
</html>