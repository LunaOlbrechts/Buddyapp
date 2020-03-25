<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="css" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Buddy app |</title>
</head>
<body>
<?php include_once("include/nav.inc.php"); ?>

<div class="buddyProfile">
    <div class="container">
        <form method="POST" class="form">
        <h4 class="title-complete-profile">Verander jouw wachtwoord</h4>
            <?php if(isset($error)):?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif ?>
            <?php if(!isset($successMessage)):?>

            <div class="form-group">
            <p class="form-title">Huidig wachtwoord</p>
                <input type="text" class="form-control" name="oldPassword" placeholder="Huidig wachtwoord">
            </div>

            <div class="form-group">
            <p class="form-title">Nieuw wachtwoord</p>
                <input type="text" class="form-control" name="newPassword" placeholder="Nieuw wachtwoord">
            </div>

            <p class="form-title">Herhaal nieuw wachtwoord</p>
                <input type="text" class="form-control" name="newPasswordRepeat" placeholder="Nieuw wachtwoord">
            </div>


            <?php endif?>
            <?php if(isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
            <?php endif ?>
        </form>
    </div>
</div>
</body>
</html>