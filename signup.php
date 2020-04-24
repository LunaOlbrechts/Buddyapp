<?php
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/UserManager.php");

    session_start();

    if(!empty($_POST)) {
        try {
            $user = new User();
            $user->setEmail(htmlspecialchars($_POST['email']) );
            $user->setFirstName(htmlspecialchars($_POST['firstName']));
            $user->setLastName(htmlspecialchars($_POST['lastName']) );
            $user->setUserName(htmlspecialchars($_POST['userName']));
            $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]));
            //echo $user->getPassword();
            $id = UserManager::save($user);

            if ($id) {
                $_SESSION['user_id'] = $id;
                $_SESSION['first_name'] = $user->getFirstName();
                $success = "user saved!";
                header("Location: complete.profile.php");
            }
        } catch (\Throwable $th) {
            //throw error
            $error = $th->getMessage();
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
    <title>Buddy app |Signup</title>
</head>
<body>

    <div class="container mt-5">

    <h2 form__title>Register</h2>

    <?php if(isset($error)): ?>
            <div class="error mr-5"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

        <?php if(isset($success)): ?>
                <div class="success mr-5"><?php echo $success ?></div>
        <?php endif; ?>        

 
    <form action="" method="post">


        <div class="form-group">
            <label for="email">E-mail:</label>
            <input class="form-control" type="text" name="email" id="email" placeholder="Enter your e-mail">
            <div id="email_response" ></div>
        </div>

        <div class="form-group">
            <label for="firstname">First name:</label>
            <input class="form-control" type="text" name="firstName" id="firstname" placeholder="Enter your first name">
        </div>

        <div class="form-group">
            <label for="lastname">Last name:</label>
            <input class="form-control" type="text" name="lastName" id="lastname" placeholder="Enter your last name">
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input class="form-control" type="text" name="userName" id="username" placeholder="Enter your username">
            <div id="username_response" ></div>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password">
        </div>

        <div class="progress form-group" style="height: 10px">
            <progress class="progress-bar" max="100" min="0" id="strength" style="width: 700px"></progress>
        </div>

        <div class="form-group">
            <label for="passwordconf">Password Confirm:</label>
            <input class="form-control" type="password" name="passwordconf" id="passwordconf">
        </div>

        <div class="form-group">
            <input class="btn border" name="signup-btn" id="btnSignUp" type="submit" value="Sign me up">
        </div>    
    
        <div>
            <a href="login.php">Already have an account? Log in here</a>
        </div>
    </form>

    </div>
    </body>

    <script src="jquery-3.5.0.js"></script>        
    <script src="script.js"></script>

</body>

<script>
        // add variabele to stock in the id password
        var password = document.getElementById("password")
        password.addEventListener('keyup', function() {
            checkPassword(password.value)
        })

        function checkPassword(password) {
            var strengthBar = document.getElementById('strength')
            var strength = 0
            if (password.match(/[a-zA-Z0-9][a-zA-Z0-9]+/)) {
                strength += 1
            }
            if (password.match(/[~<>?]+/)) {
                strength += 1
            }
            if (password.match(/[!@£$^&*()]+/)) {
                strength += 1
            }
            if (password.length > 5) {
                strength += 1
            }

            switch (strength) {
                case 0:
                        strengthBar.value = 0;
                        var signUp = false;
                        break
                case 1:
                        strengthBar.value = 40;
                        var signUp = false;
                        break
                case 2:
                        strengthBar.value = 60;
                        var signUp = false;
                        break
                case 3:
                        strengthBar.value = 80;
                        var signUp = true;
                        break
                case 4:
                        strengthBar.value = 100;
                        var signUp = true;
                        break
            }
        }

</script>

</html>