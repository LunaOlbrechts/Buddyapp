<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");

session_start();
$id =  $_SESSION["user_id"];

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if ($_POST['updateDetails']) {
        try {
            if (!empty($_POST['updateDetails'])) {
                $user = new User();
                $user->setDescription($_POST['description']);
                $user->setId($id);

                UserManager::updateUserDetails($user);

                $profileInformationSuccess = "Successfully updated your profile information!";
            }
        } catch (\Throwable $th) {
            $profileInformationError = $th->getMessage();
        }
    } else if ($_POST['updateProfilePicture']) {
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
                        $user = new User();
                        $user->setProfilePicture("uploads/" . $image_file);
                        $user->setId($id);
                        UserManager::updateUserProfilePicture($user);
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
    } else if ($_POST['updateEmail']) {
        try {
            $user = new User();
            $user->setPasswordForVerification($_POST['passwordForEmailVerification']);
            $user->setEmail($_POST['email']);
            $user->setId($id);

            UserManager::updateEmail($user);

            $emailSuccess = "Your email has been updated";
        } catch (\Throwable $th) {
            $emailerror = $th->getMessage();
        }
    } else if ($_POST['updatePassword']) {
        try {
            $user = new User();
            $user->setPasswordForVerification($_POST['oldPassword']);
            $user->setnewPassword($_POST['newPassword']);
            $user->setRepeatedNewPassword($_POST['reapeatNewPassword']);
            $user->setId($id);

            UserManager::updatePassword($user);

            $passwordSuccess = "Your password has been updated!";
        } catch (\Throwable $th) {
            $passworderror = $th->getMessage();
        }
    }
} else {
    header("Location: login.php");
}


$userData = UserManager::getUserFromDatabase($user);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Buddy app | Profile</title>
</head>

<body>
    <?php include_once("include/nav.inc.php"); ?>
    <div class="container mt-5">
        <h1>Profile</h1>

        <?php foreach ($userData as $data) : ?>
            <div class="container mt-5 p-0">
                <h2>Profile Picture</h2>
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
                        <label>Change Profile Picture</label>
                        <input type="file" name="profilePicture" class="form-control" />
                    </div>
                    <input class="btn btn-primary m-0" type="submit" value="Change Picture" name="updateProfilePicture">
                </form>
            </div>

            <div class="container mt-5 p-0">
                <h2>Profile Information</h2>
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
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($data['description']) ?></textarea>
                    </div>
                    <input class="btn btn-primary m-0" type="submit" value="Update Information" name="updateDetails">
                </form>
            </div>

            <div class="container mt-5 p-0">
                <h2>Change Email Address</h2>
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
                        <label>Email address</label>
                        <input name="email" value="<?php echo htmlspecialchars($data['email']) ?>" type="email" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Enter password as verification</label>
                        <input name="passwordForEmailVerification" type="password" class="form-control" placeholder="Password">
                    </div>
                    <input class="btn btn-primary m-0" type="submit" value="Change Email" name="updateEmail">
                </form>
            </div>

            <div class="container mt-5 p-0 mb-5">
                <h2>Change Password</h2>
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
                        <label for="exampleInputPassword1">Old Password</label>
                        <input name="oldPassword" type="password" class="form-control" placeholder="Old password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input name="newPassword" type="password" class="form-control" placeholder="New password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Repeat new Password</label>
                        <input name="reapeatNewPassword" type="password" class="form-control" placeholder="Repeat new password">
                    </div>
                    <input class="btn btn-primary m-0" type="submit" value="Change Password" name="updatePassword">
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>