<?php
session_start();
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Buddies.php");


$id =  $_SESSION["user_id"];



if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $buddy = new Buddies();
    $buddies = Buddies::findRequest($buddy);

    if ($_POST['accept']) {
        try {
            $_SESSION['requested'] = $_POST['requested'];
           
        } catch (\Throwable $th) {
            
        }
    }

    if (isset($_POST['accept']) && ($_POST['accept'])) {
        $buddy = new Buddies();
        Buddies::makeBuddy($buddy);
        header("Location: index.php");
    }

    if (isset($_POST['deny'])) {
        $buddy = new Buddies();
    }    
    
    
}

        

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Request</title>
</head>

<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>
    

    <div class="card-group container mt-5">

        <div class="card">
            <?php foreach ($buddies as $buddy) :  ?>
              <?php echo $buddy["sender"] . " wants to be your buddy!"; ?>
              <form method="POST" class="mx-auto"> 

            <div class="btn-group" role="group" > 
                <input type="submit" value="View profile" name="profile" class="btn btn-info mt-5"></input>
            </div>
                        
            </form>
            <form method="POST" class="mx-auto">
            <input type="hidden" value="<?php echo htmlspecialchars($buddy['sender']) ?>" name="requested">
                        
                        
            <div class="btn-group" role="group" >        
                <input type="submit" value="Accept" name="accept" class="btn btn-success mr-3"></input>
                <input type="submit" value="Deny" name="deny" class="btn btn-danger mr-3"></input>
            </div>
                        
            </form>
            
              <?php endforeach ?>
            
            
        </div> 

    </div>

</body>

</html>