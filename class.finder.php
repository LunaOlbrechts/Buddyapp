<?php

include_once(__DIR__ . "/classes/SearchClass.php");

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    if (isset($_GET['searchClass'])) {
        $searchField = trim($_GET['searchField'], " t.");
        $searchClass = SearchClass::findClass($searchField);

        if (empty($searchField)) {
            $error = 'Vul een klaslokaal in';
        } elseif (strlen($searchField) < 3) {
            $error = "Voer minstens 3 karakters in ('Gebouw','verdieping','lokaal')";
        }

        if (strlen($searchField) > 2) {
            if (count($searchClass) > 0) {
                foreach ($searchClass as $class) {
                    $succes = '<div class="font-weight-bold">' . 'Lokaal: '
                        . htmlspecialchars($class['classRoom']) . '</div>' . '<div>' . htmlspecialchars($class['description']) . '</div>';
                }
            } else {
                $error = 'Geen lokaal gevonden';
            }
        }
    }
} else {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buddy app | Lokaal vinder</title>
</head>

<body>

    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <form method="GET" action="">
        <div class="container mt-5">
            <h1 class="col-md-5">Lokaal vinder</h1>
            <p>Geef hieronder een lokaal in om te zoeken naar een beschrijving</p>
            <div class="form-group">
                <label for="class"><b>Geef een lokaal in (vb: Z3.04)</b></label>
                <input class="form-control" type="text" name="searchField" placeholder="Lokaal" id='searchClass' autocomplete="off">
                <div><a class="classLink" id="autocompleteClass"></a></div>
            </div>

            <div class="form-group">
                <input class="btn border search-name-btn" type="submit" value="Zoek" name='searchClass'>
            </div>
        </div>
    </form>

    <div class="container mt-5 class-description">
        <?php if (isset($succes)) : ?>
            <p id="description"><?php echo $succes; ?></p>
        <?php endif; ?>

        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

    </div>
    <?php include_once(__DIR__ . "/include/footer.inc.php"); ?>

    <script src="/js/autocompleteClass.js"></script>
</body>

</html>