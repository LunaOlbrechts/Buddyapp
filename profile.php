<?php

spl_autoload_register();
session_start();

$id =  $_SESSION["user_id"];

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if (isset($_POST['updateDetails']) && $_POST['updateDetails']) {
        try {
            if (!empty($_POST['updateDetails'])) {
                $user = new \src\BeMyBuddy\User();
                $user->setDescription($_POST['description']);
                $user->setId($id);

                \src\BeMyBuddy\UserManager::updateUserDetails($user);

                $profileInformationSuccess = "Successfully updated your profile information!";
            }
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    } else if (isset($_POST['updateProfilePicture']) && $_POST['updateProfilePicture']) {
        try {
            $file = $_FILES["profilePicture"]["name"];
            $image_file = time() . str_replace(' ', '_', $file);
            $type = $_FILES["profilePicture"]["type"]; //file name "txt_file" 
            $temp = $_FILES["profilePicture"]["tmp_name"];
            $size = $_FILES["profilePicture"]["size"];

            if (!empty($file)) {
                if ($type == "image/jpg" || $type == 'image/jpeg' || $type == 'image/png') //check file extension
                {
                    if ($size < 5000000) {
                        move_uploaded_file($temp, "uploads/" . $image_file); //move upload file temperory directory to your upload folder
                        $user = new \src\BeMyBuddy\User();
                        $user->setProfilePicture("uploads/" . $image_file);
                        $user->setId($id);
                        \src\BeMyBuddy\UserManager::updateUserProfilePicture($user);
                        $ProfilePicturesuccess = "Your profile picture has been updated!";
                    } else {
                        $ProfilePictureError = "The max upload size is 5MB!"; //error message file extension
                    }
                } else {
                    $ProfilePictureError = "Only files with the extension JPG , JPEG , PNG are supported!"; //error message file extension
                }
            } else {
                $ProfilePictureError = "You need to upload a picture first!";
            }
        } catch (\Throwable $th) {
            $ProfilePictureError = $th->getMessage();
        }
    } else if (isset($_POST['updateEmail']) && $_POST['updateEmail']) {
        try {
            $user = new \src\BeMyBuddy\User();
            $user->setPasswordForVerification($_POST['passwordForEmailVerification']);
            $user->setEmail($_POST['email']);
            $user->setId($id);

            \src\BeMyBuddy\UserManager::updateEmail($user);

            $emailSuccess = "Your email has been updated";
        } catch (\Throwable $th) {
            $emailerror = $th->getMessage();
        }
    } else if (isset($_POST['updatePassword']) && $_POST['updatePassword']) {
        try {
            $user = new \src\BeMyBuddy\User();
            $user->setPasswordForVerification($_POST['oldPassword']);
            $user->setnewPassword($_POST['newPassword']);
            $user->setRepeatedNewPassword($_POST['reapeatNewPassword']);
            $user->setId($id);

            \src\BeMyBuddy\UserManager::updatePassword($user);

            $passwordSuccess = "Your password has been updated!";
        } catch (\Throwable $th) {
            $passworderror = $th->getMessage();
        }
    }
} else {
    header("Location: login.php");
}

$userData = \src\BeMyBuddy\UserManager::getUserFromDatabase($id);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Buddy app | Profiel aanpasssen</title>
</head>
<body>

    <?php include_once("include/nav.inc.php"); ?>

    <div class="container mt-5">
        <h1>Profiel</h1>
        <a href="/userFeed.php" class="btn btn-primary">Mijn posts</a>
        <?php foreach ($userData as $data) : ?>
            <div class="container mt-5 p-0">
                <h2>Profielfoto</h2>
                <?php if (isset($ProfilePictureError)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($ProfilePictureError) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($ProfilePicturesuccess)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($ProfilePicturesuccess) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div style="background-image: url(<?php echo htmlspecialchars($data['profilePicture']) ?>); width: 200px; height: 200px; background-size: cover; background-position: center" ;></div>
                    <div class="form-group mt-3">
                        <label>Profielfoto aanpassen</label>
                        <input type="file" name="profilePicture" class="form-control" />
                    </div>
                    <input class="btn btn-primary m-0" type="submit" value="Update profielfoto" name="updateProfilePicture">
                </form>
            </div>

            <div class="container mt-5 p-0">
                <h2>Informatie</h2>
                <?php if (isset($profileInformationSuccess)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($profileInformationSuccess) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($profileInformationError)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($profileInformationError) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" accept-charset="UTF-8">
                    <div class="form-group">
                        <label>Beschrijving</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($data['description']) ?></textarea>
                    </div>
                    <input class="btn btn-primary m-0" type="submit" value="Update informatie" name="updateDetails">
                </form>
            </div>

            <div class="container mt-5 p-0">
                <h2>Email veranderen</h2>
                <?php if (isset($emailSuccess)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($emailSuccess) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($emailerror)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($emailerror) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nieuw email</label>
                        <input name="email" value="<?php echo htmlspecialchars($data['email']) ?>" type="email" class="form-control" placeholder="Nieuw email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Vul wachtwoord in als verificatie</label>
                        <input name="passwordForEmailVerification" type="password" class="form-control" placeholder="Wachtwoord">
                    </div>
                    <input class="btn btn-primary m-0" type="submit" value="Update Email" name="updateEmail">
                </form>
            </div>

            <div class="container mt-5 p-0 mb-5">
                <h2>Wachtwoord veranderen</h2>
                <?php if (isset($passwordSuccess)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($passwordSuccess) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($passworderror)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($passworderror) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Oud wachtwoord</label>
                        <input name="oldPassword" type="password" class="form-control" placeholder="Oud wachtwoord">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nieuw wachtwoord</label>
                        <input name="newPassword" type="password" class="form-control" placeholder="Nieuw wachtwoord">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Herhaal nieuw wachtwoord</label>
                        <input name="reapeatNewPassword" type="password" class="form-control" placeholder="Herhaal nieuw wachtwoord">
                    </div>
                    <input class="btn btn-primary m-0" type="submit" value="Change Password" name="updatePassword">
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include_once(__DIR__ . "/include/footer.inc.php"); ?>

</body>
</html>