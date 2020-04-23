<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Forum.php");

include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Buddies.php");

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {

    $questions = Forum::getQuestions();

    $comments = Forum::getComments();

    if ($questions) {

        if (!empty($_POST['comment'])) {
            $comment = $_POST['comment'];
            $user = UserManager::getUserFromDatabase();

            $username = $user[0]['userName'];

            Forum::saveComment($comment, $username);
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
    <link rel="stylesheet" href="./css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <title>Document</title>
    <style>
        .card-body {
            min-width: 300px;
        }

        .btn {
            font-size: 0.7em !important;
            min-width: 150px !important;
            margin-bottom: 10px;
            background-color: none;
            color: blue;
        }

        .card {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>
    <div class="container d-flex justify-content-center">
        <div class="faq">
            <nav id="navbar-example2" class="navbar navbar-light bg-light">
                <a class="navbar-brand" href="#"></a>
                <ul class="nav nav-pills">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="FAQ" href="#" role="button" aria-haspopup="true" aria-expanded="false">FAQ</a>
                        <div class="dropdown-menu">
                            <!-- php for each faq as question-->
                            <a class="dropdown-item" href="#one">one</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mdo">Forum</a>
                    </li>
                </ul>
            </nav>
            <div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                <!-- php for each faq as question-->
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>

                <!-- php for each questions as question-->
                <?php foreach ($questions as $question) : ?>
                    <?php $_SESSION['questionId'] = $question["id"] ?>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $question["userName"] ?></h5>
                            <p class="card-text"><?php echo $question["question"] ?></p>
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $question["id"] ?>" aria-expanded="false" aria-controls="collapse<?php echo $question["id"] ?>">
                                Opmerkingen
                            </button>
                            <!-- php for each comments as comment-->
                            <?php foreach ($comments as $comment) : ?>
                                <?php if ($comment['forum_question_id'] == $question["id"]) : ?>
                                    <div class="collapse" id="collapse<?php echo $question["id"] ?>">
                                        <div class="card card-body">
                                            <?php echo  $comment["userName"] . ": " . $comment["comment"] ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>

                            <form method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="" name="comment" placeholder="comment">
                                    <input type="hidden" value="<?php echo htmlspecialchars($question["id"]) ?>" name="questionId"></input>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="./css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
</body>

</html>