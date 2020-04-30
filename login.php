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
            // nieuwe instantie klasse User
            $user = new User();
            // stellen pw gelijk aan ingevulde veldje 'password'
            $user->setPasswordForVerification($_POST['password']);
            // stellen email gelijk aan ingevulde veldje 'email'
            $user->setEmail($_POST['email']);
            
            $result = UserManager::logIn($user);
        
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

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Buddy app | Sign In</title>
</head>

<body>
    <form action="" method="post" id="captch_form">
        <div class="container mt-5 login-form">
            <h2 form__title>Sign In</h2>

            <?php if (isset($error)) : ?>
                <div class="mr-5">
                    <p>
                        <?php echo $error; ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label class="title" for="email">E-mail:</label>
                <input class="form-control email-input" type="text" id='email' name='email' placeholder="Enter e-mail">
            </div>
            <div class="form-group">
                <label class="title" for="password">Password:</label>
                <input class="form-control password-input" type="password" id='password' name='password' placeholder="Enter password">
            </div>

            <!--<div class="form-group">
            <div class="form-group">
                <label>Code</label>
                <div class="input-group">
                    <input type="text" name="captcha_code" id="captcha_code" class="form-control" />
                    <span class="input-group-addon" style="padding:0">
                    <img src="image.php" id="captcha_image" />
                    <div id="captcha_response" ></div>
                    </span>
                </div>
            </div>
            </div>-->

            <div class="form-group">
                <input class="btn border login-btn" name="login" type="submit" value="Log in" name='submit' id="login">
            </div>

            <div>
                <a href="signup.php" class="signup-btn">Don't have an account yet? Sign up here</a>
            </div>
        </div>
    </form>

</body>

</html>
<!--
<script src="jquery-3.5.0.js"></script> 

<script>

 $(document).ready(function(){
  $('#captch_form').on('submit', function(event){
   event.preventDefault();
   if($('#captcha_code').val() == '')
   {
    alert('Enter Captcha Code');
    $('#login').attr('disabled', 'disabled');
    return false;
   }
   else
   {
    alert('Form has been validate with Captcha Code');
    $('#captch_form')[0].reset();
    $('#captcha_image').attr('src', 'image.php');
   }
  });

  $('#captcha_code').on('blur', function(){
   var code = $('#captcha_code').val();
   
   if(code == '')
   {
    alert('Enter Captcha Code');
    $('#login').attr('disabled', 'disabled');
   }
   else
   {
    $.ajax({
     url:'../Buddyapp/ajax/checkpassword.php',
     method:"POST",
     data:{code:code},
     success:function(data)
     {
      if(data == 'success')
      {
       $('#login').attr('disabled', false);
      }
      else
      {
       $('#login').attr('disabled', 'disabled');
       alert('Invalid Code');
      }
     }
    });
   }
  });

 });
</script>
-->