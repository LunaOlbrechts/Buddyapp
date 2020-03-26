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

    session_start();

    function canLogin($email,$password){
        $conn = new mysqli("localhost","root","","buddy_app");
        $email = mysqli_real_escape_string($conn,$email);
        $password = mysqli_real_escape_string($conn,$password);
        $sql = "select password from tl_user where email='$email'";
        $result = $conn->query($sql);
        if($result->num_rows != 1){
			return false;
        }
        var_dump($password);
        $user = $result->fetch_assoc();  //fetch=pakken
		$hash = $user['password'];
		if(password_verify($password, $hash)){
			return true;
		}else{
			return false;
		}
    }

    /*session_start();

    $conn = new mysqli("localhost","root","","buddy_app");

    if(!empty($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $email = mysqli_real_escape_string($conn,$email);
        $password = mysqli_real_escape_string($conn,$password);

        $password = md5($password);
        //var_dump($password);
        $sql = "SELECT * FROM tl_user WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result) == 1){
            header('Location:index.php');
        } else{
            
        }

    }

    function canLogin($email,$password){
        if('email' === $email && 'password' === $password){
            return true;
        } return false;
    }*/

    // if form was submit
    if(!empty($_POST) ) {
    $email =  $_POST ['email'];
    $password =  $_POST ['password'];
    // check if required fields are not empty
        if( !empty($email) && !empty($password) ){
            if(canLogin($email,$password) === true){ // if email & password match
                $_SESSION["email"] = $email;
                header('Location: index.php');	// direct to index.php
            } else{
            $error = "Cannot log you in";
            }
        } elseif( empty($email) && empty($password) ){
            $error = "Email & password are required";
        } elseif(empty($email)){
            $error = "Email is required";
        } elseif(empty($password)){
            $error = "Password is required";
        }
    }

    /*
    //start a session at the beginning of your file 
    session_start();

    // connect to db 
    $conn = new mysqli("localhost","root","","buddy_app");


    if(!empty($_POST['submit'])){
        session_start();
        $email = $_POST['email'];
        $password = $_POST['password'];

        $email = mysqli_real_escape_string($conn,$email);
        $password = mysqli_real_escape_string($conn,$password);

        var_dump($password);
        $password = md5($password);
        $sql = "SELECT * FROM tl_user WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($result) == 1){
            $_SESSION['message'] = "You are logged in";
            $_SESSION['email'] = $email;
            header('Location:complete.profile.php'); // go to profile page 
        }else{
            $_SESSION['message'] = "Email/password incorrect";
        }
    }*/

    /*
    // if form is submit
    if( !empty($_POST) ) {
        // check if required fields are not empty
        $email = $_POST["email"];
        $password = $_POST["password"];

        // query 
        if(isset($_POST['submit'])){
            if(!empty($email) && !empty($password)){
            
            } else{
            $error = 'Fill in email & password';
            }
    } else{
        $error = 'Cannot log you in';
    } 

    }
    */

/*
session_start();
    if(empty($email) && empty($password)){
        $sql = "select * from 'tl_user' where email = '$email' && password = '" .md5($password)."'";
    }
*/


/*
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


    }*/
    
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

        <?php if(isset($error)): ?>
				<div class="mr-5">
					<p>
						<?php echo $error;?>
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