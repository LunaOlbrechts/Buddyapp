<?php
    include_once(__DIR__ . "/classes/User.php");

    if(!empty($_POST)) {

        try {
            $user = new User();
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setFirstName(htmlspecialchars($_POST['firstname']));
            $user->setLastName(htmlspecialchars($_POST['lastname']));
            $user->setPassword(htmlspecialchars($_POST['password']));

            $user->save();
          //  $success = "user saved!";
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
    <?php include_once("include/nav.inc.php"); ?>

    <?php if(isset($error)): ?>
            <div class="error"><?php echo $errors; ?></div>
    <?php endif; ?>

        <?php if(isset($success)): ?>
                <div class="success"><?php echo $success ?></div>
        <?php endif; ?>        

 
    <form action="" method="post">

        <div>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email">
        </div>

        <div>
            <label for="firstname">First name:</label>
            <input type="text" name="firstname" id="firstname">
        </div>

        <div>
            <label for="lastname">Last name:</label>
            <input type="text" name="lastname" id="lastname">
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="text" name="password" id="password">
        </div>

        <div>
            <label for="passwordconf">Password Confirm:</label>
            <input type="password" name="passwordconf" id="passwordconf">
        </div>

        <div>
            <input class="btn btn-primary" name="signup-btn" type="submit" value="Sign me up">
        </div>    
    
    </form>

</body>
</html>