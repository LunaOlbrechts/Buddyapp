<?php
       include_once(__CLASS__ ."classes/User.php");
       include_once(__CLASS__ ."classes/UserManager.php");

        $currentUser = UserManager::getUserFromDatabase();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Navigation</title>
</head>
<body>
    <nav class="navbar nav bg-light">
        <a href="index.php" class="logo">Buddy app</a>
        <a href="index.php">Home</a>
        <!--<a href="mylist.php"></a>-->
        <a href="search.php">Search for a buddy</a>
        
        <form action="" method="post">
            <input type="text">
        </form>

        <a href="logout.php" class="navbar__logout">Hi <?php echo $currentUser[0]['firstName']?>, logout?</a>
        <a class="navbar-brand" href="#">
            <img src="<?php echo $currentUser[0]['profilePicture']?>" width="50" height="50" alt="profile picture">
        </a>
    </nav>
</body>
</html>