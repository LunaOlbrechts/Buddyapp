<?php
     include_once(__DIR__ ."/classes/User.php");
     include_once(__DIR__ ."/classes/UserManager.php");

     session_start();

    $searchField = trim($_GET['searchField'], " t.");
    //$searchField = $_GET['searchField'];
    //$replace_string = str_replace('.','',$searchField);

     if ($_GET['searchClass']) {
        $searchClass = UserManager::findClass();
        if (empty($searchField)) {
            $error = 'Vul een klaslokaal in';
        } elseif (strlen($searchField) < 3) {
            $error = "Voer minstens 3 karakters in ('Gebouw','verdieping','lokaal')";
        }

        if (strlen($searchField) > 2) {
            if (count($searchClass) > 0) {
                foreach ($searchClass as $class) {
                    $succes = '<div class="font-weight-bold">' . 'Lokaal: ' 
                    . $class['classRoom'] . '</div>' . '<div>' . $class['description'] . '</div>';
                }
            } else {
                $error = 'Geen lokaal gevonden';
            }
        }
     }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokaal vinder</title>
</head>
<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <form method="GET" action="">
        <div class="container mt-5">
            <h1 class="col-md-5">Lokaal vinder</h1>
            <p>Geef hieronder een lokaal in om te zoeken naar een beschrijving</p>
            <div class="form-group">
                <label for="class"><b>Geef een lokaal in (vb: Z3.04)</b></label>
                <input class="form-control" type="text" name="searchField" placeholder="Lokaal">
            </div>

            <div class="form-group">
                <input class="btn border" type="submit" value="Zoek" name='searchClass'>
            </div>
        </div>
    </form>

    <div class="container mt-5">
        <?php if(isset($succes)): ?>
            <p><?php echo $succes; ?></p>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

    </div>
    <?php include_once(__DIR__ . "/include/footer.inc.php"); ?>
</body>
</html>