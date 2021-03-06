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
            header("Location: signup.mail.php");
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
    <title>Buddy app | Registreren</title>
</head>
<body>
    
    <div class="container mt-5 signup shadow-lg p-3 mb-5 bg-white rounded">
        <h2 form__title>Registreren</h2>

        <?php if (isset($error)) : ?>
            <div class="error mr-5"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <div class="success mr-5"><?php echo htmlspecialchars($success) ?></div>
        <?php endif; ?>


        <form action="" method="post">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input class="form-control" type="text" name="email" id="email" placeholder="Geef je e-mail adres in">
                <div id="email_response"></div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="firstname">Voornaam:</label>
                    <input class="form-control" type="text" name="firstName" id="firstname" placeholder="Voornaam">
                </div>
                <div class="col">
                    <label for="lastname">Achternaam:</label>
                    <input class="form-control" type="text" name="lastName" id="lastname" placeholder="Achternaam">
                </div>
            </div>

            <div class="form-group">
                <label for="username">Gebruikersnaam:</label>
                <input class="form-control" type="text" name="userName" id="username" placeholder="Gebruikersnaam">
                <div id="username_response"></div>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div class="progress form-group" style="height: 10px">
                <progress class="progress-bar" max="100" min="0" id="strength" style="width: 1200px"></progress>
            </div>

            <div class="form-group">
                <label for="passwordconf">Bevestig wachtwoord:</label>
                <input class="form-control" type="password" name="passwordconf" id="passwordconf">
                <div id="message"></div>
            </div>

            <div class="form-group">
                <input class='btn border login-btn' name='signup-btn' id='btnSignUp' type='submit' value='Registreer mij'>
            </div>

            <div>
                <a href="login.php" class="signup-btn">Heb je al een account? Log in hier.</a>
            </div>
        </form>
    </div>

    <script src="jquery-3.5.0.js"></script>
    <script src="script.js"></script>

</body>

</html>