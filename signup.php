<?php
    include_once(__DIR__ . "/classes/User.php");

    if(!empty($_POST)) {
        try {
            $user = new User();
            $user->setEmail(htmlspecialchars($_POST['email']) );
            $user->setFirstName(htmlspecialchars($_POST['firstname']) );
            $user->setLastName(htmlspecialchars($_POST['lastname']) );
            $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]) );
            //echo $user->getPassword();
            $user->save();

            $success = "user saved!";
            header("Location: complete.profile.php");
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
            <div class="error mr-5"><?php echo $error; ?></div>
    <?php endif; ?>

        <?php if(isset($success)): ?>
                <div class="success mr-5"><?php echo $success ?></div>
        <?php endif; ?>        

 
    <form action="" method="post">


        <div class="form-group">
            <label for="email">E-mail:</label>
            <input class="form-control" type="text" name="email" id="email" placeholder="Enter your first e-mail" value="l@student.thomasmore.be">
        </div>

        <div class="form-group">
            <label for="firstname">First name:</label>
            <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Enter your first name" value="Luna">
        </div>

        <div class="form-group">
            <label for="lastname">Last name:</label>
            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Enter your last name" value="Olbrechts">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password">
        </div>

        <div class="form-group">
            <label for="passwordconf">Password Confirm:</label>
            <input class="form-control" type="password" name="passwordconf" id="passwordconf">
        </div>

        <div>
            <input class="btn border" name="signup-btn" type="submit" value="Sign me up">
        </div>    
    
    </form>

    </div>

  
</body>
</html>