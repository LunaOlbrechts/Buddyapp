<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Mail.php");

if (!empty($_POST)) {
    try {
        $user = new User();
        $user->setEmail(htmlspecialchars($_POST['email']));
        $user->setFirstName(htmlspecialchars($_POST['firstName']));
        $user->setLastName(htmlspecialchars($_POST['lastName']));
        $user->setUserName(htmlspecialchars($_POST['userName']));
        $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]));
        $id = UserManager::save($user);
        
        if ($id) {
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['first_name'] = $user->getFirstName();
            $_SESSION['email'] = $user->getEmail();
            $success = "Sign up completed!";
            Mail::sendEmailSignup();
            header("Location: complete.profile.php");
        }             
    } catch (\Throwable $th) {
        //throw error
        $error = $th->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Buddy app | Signup</title>
</head>
<body>

    <div class="container mt-5">
        <h2 form__title>Sign up</h2>

        <?php if (isset($error)) : ?>
            <div class="error mr-5"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <div class="success mr-5"><?php echo htmlspecialchars($success) ?></div>
        <?php endif; ?>


        <form action="" method="post">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input class="form-control" type="text" name="email" id="email" placeholder="Enter your e-mail">
                <div id="email_response"></div>
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
                <div id="username_response"></div>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div class="progress form-group" style="height: 10px">
                <progress class="progress-bar" max="100" min="0" id="strength" style="width: 1200px"></progress>
            </div>

            <div class="form-group">
                <label for="passwordconf">Password Confirm:</label>
                <input class="form-control" type="password" name="passwordconf" id="passwordconf">
                <div id="message"></div>
            </div>

            <div class="form-group">
                <input class='btn border login-btn' name='signup-btn' id='btnSignUp' type='submit' value='Sign me up'>
            </div>

            <div>
                <a href="login.php" class="signup-btn">Already have an account? Log in here</a>
            </div>
        </form>
    </div>

    <script src="jquery-3.5.0.js"></script>
    <script src="script.js"></script>

</body>
</html>