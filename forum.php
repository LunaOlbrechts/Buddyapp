<?php

include_once(__DIR__ . "/classes/Forum.php");
include_once(__DIR__ . "/classes/UserManager.php");

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $user = UserManager::getUserFromDatabase();
    $questions = Forum::getQuestions();
    $comments = Forum::getComments();
    $pinned = Forum::getPinnedQuestion();
    $votedComments = Forum::getVotedComments($_SESSION["user_id"]);

    $username = $user[0]['userName'];

    if ($questions) {
        if (!empty($_POST['comment'])) {
            $comment = $_POST['comment'];
            Forum::saveComment($comment, $username);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['pin']) && $_POST['pin'] == "on") {
                $result = Forum::savePinnedQuestion();
            } else {
                $notPinned = Forum::deletePinnedQuestion();
            }
        }
    }
    if (!empty($_POST['postedQuestion'])) {
        Forum::saveQuestion($_POST['postedQuestion'], $username);
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
    <link rel="stylesheet" href="./css/style.css">
    <title>Buddy app | forum</title>
</head>

<body>

    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>

    <div class="container forum-question">
        <div>
            <form method="POST">
                <div class="form-group input-form-question">
                    <label for="question" aria-placeholder="Question"><?php echo htmlspecialchars($user[0]['userName']); ?></label>
                    <textarea class="form-control" id="postedQuestion" rows="2" name="postedQuestion" placeholder="Typ hier je vraag"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Plaats jouw vraag</button>
            </form>
        </div>

        <div class="faq">
            <div>
                <!-- php for each faq as question-->
                <h3>FAQ</h3>
                <?php foreach ($pinned as $pinnedQuestion) : ?>
                    <!-- FAQ cards-->
                    <form method="POST">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($pinnedQuestion["userName"]) ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($pinnedQuestion["question"]) ?></p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo htmlspecialchars($pinnedQuestion["id"]) ?>" aria-expanded="false" aria-controls="collapse<?php echo htmlspecialchars($pinnedQuestion["id"]) ?>">
                                    Bekijk opmerkingen
                                </button>

                                <?php if ($user[0]['admin'] == 1) : ?>
                                    <form method="POST">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pin" <?php if ($pinnedQuestion['pinned'] == 1) : echo "checked";
                                                                                                        endif ?>>
                                            <label class="form-check-label" for="pin">
                                                Pin
                                            </label>
                                            <input type="hidden" value="<?php echo htmlspecialchars($pinnedQuestion["id"]) ?>" name="questionId"></input>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                <?php endif ?>

                                <!-- php for each comments as comment-->
                                <?php if (!empty($comments)) : ?>
                                    <?php foreach ($comments as $comment) : ?>
                                        <?php if ($comment['forum_question_id'] == $pinnedQuestion["id"]) : ?>
                                            <div class="collapse" id="collapse<?php echo htmlspecialchars($pinnedQuestion["id"]) ?>">
                                                <div class="card card-body">
                                                    <?php echo  htmlspecialchars($comment["userName"]) . ": " . htmlspecialchars($comment["comment"]) ?>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="" name="comment" placeholder="Opmerking">
                                    <input type="hidden" value="<?php echo htmlspecialchars($pinnedQuestion["id"]) ?>" name="questionId"></input>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endforeach ?>

                <h3>Vragen</h3>
                <!-- php for each questions as question-->
                <?php foreach ($questions as $question) : ?>
                    <!-- Questions cards-->
                    <?php if ($question['pinned'] == 0) : ?>
                        <form method="POST">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($question["userName"]) ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($question["question"]) ?></p>
                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo htmlspecialchars($question["id"]) ?>" aria-expanded="false" aria-controls="collapse<?php echo htmlspecialchars($question["id"]) ?>">
                                        Bekijk opmerkingen
                                    </button>

                                    <?php if (array_key_exists("admin", $user[0])) : ?>
                                        <?php if ($user[0]['admin'] == 1) : ?>
                                            <form method="POST">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="pin" <?php if ($question['pinned'] == 1) : echo "checked";
                                                                                                                endif ?>>
                                                    <label class="form-check-label" for="pin">
                                                        Pin
                                                    </label>
                                                    <input type="hidden" value="<?php echo htmlspecialchars($question["id"]) ?>" name="questionId"></input>
                                                    <button type="submit" class="btn btn-primary">Bevesting pin</button>
                                                </div>
                                            </form>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <!-- php for each comments as comment-->
                                    <?php foreach ($comments as $comment) : ?>
                                        <?php if ($comment['forum_question_id'] == $question["id"]) : ?>
                                            <div class="collapse" id="collapse<?php echo htmlspecialchars($question["id"]) ?>">
                                                <div class="card card-body">
                                                    <p><?php echo  htmlspecialchars($comment["userName"] . ": " . $comment["comment"]) ?></p>
                                                    <?php if (in_array($comment["id"], $votedComments)) { ?>
                                                        <p class="voteNumber"><span class="number"><?php echo htmlspecialchars($comment["votes"]) ?></span><span class="vote on voted" data-id="<?php echo htmlspecialchars($comment["id"]) ?>"></span></p>
                                                    <?php } else { ?>
                                                        <p class="voteNumber"><span class="number"><?php echo htmlspecialchars($comment["votes"]) ?></span><span class="vote" data-id="<?php echo htmlspecialchars($comment["id"]) ?>"></span></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" name="comment" placeholder="Opmerking">
                                        <input type="hidden" value="<?php echo htmlspecialchars($question["id"]) ?>" name="questionId"></input>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>

    <?php include_once(__DIR__ . "/include/footer.inc.php"); ?>

    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="./css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <script src="js/vote.js"></script>

</body>

</html>