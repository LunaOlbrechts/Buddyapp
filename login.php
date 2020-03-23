<?php
    include_once(__DIR__ . "/classes/User.php");

    // make form log in user
    // if user doesn't exist in db => message: "can't login user" of "mag niet leeg zijn" "geen geldig email"
    // if user exists in db => go to profile.php of that user
    // user presses button "log out" => then go back to login.php

    // toon een foutmelding indien inloggen niet gelukt is (zie screenshot)
    // valideer al wat kan mislopen in dit formulier via PHP
    // uitloggen is mogelijk

    /*session_start();

    $conn = mysqli_connect('localhost','root','');

    mysqli_select_db($conn,'buddy_app');

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "select * from tl_user where email = '$email' && password = '$password";

    $result = mysqli_query($conn,$sql);
    if($result->num_rows != 1){
        return false;
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
				<div class="form__error">
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
            <input class="btn border" type="submit" value="Log in"> 
        </div>
        </div>
    </form>

</body>
</html>