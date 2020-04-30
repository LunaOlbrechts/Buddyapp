<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Forum.php");

include_once(__DIR__ . "/classes/UserManager.php");
include_once(__DIR__ . "/classes/Buddies.php");

session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $user = UserManager::getUserFromDatabase();
    $questions = Forum::getQuestions();
    $comments = Forum::getComments();
    $pinned = Forum::getPinnedQuestion();

    $username = $user[0]['userName'];

    if ($questions) {
        if (!empty($_POST['comment'])) {
            $comment = $_POST['comment'];

            Forum::saveComment($comment, $username);
        }

        if ($_POST['pin'] == "on") {
            $result = Forum::savePinnedQuestion();
        } else {
            $notPinned = Forum::deletePinnedQuestion();
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
    <title>Buddy app | forum</title>
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

        .vote {
            display: inline-block;
            overflow: hidden;
            width: 40px;
            height: 19px;
            cursor: pointer;
            background: url('http://i.stack.imgur.com/iqN2k.png');
            background-position: 0 -25px;
        }

        .vote.on {
            background-position: 0 2px;
        }

        .voteNumber {
            display: inline;
        }
    </style>
</head>

<body>
    <?php include_once(__DIR__ . "/include/nav.inc.php"); ?>
    <div class="container">
        <div>
            <form method="POST">
                <div class="form-group">
                    <label for="question" aria-placeholder="Question"><?php echo htmlspecialchars($user[0]['userName']); ?></label>
                    <textarea class="form-control" id="postedQuestion" rows="3" name="postedQuestion"></textarea>
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
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $pinnedQuestion["id"] ?>" aria-expanded="false" aria-controls="collapse<?php echo $pinnedQuestion["id"] ?>">
                                    Opmerkingen
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
                                <?php foreach ($comments as $comment) : ?>
                                    <?php if ($comment['forum_question_id'] == $pinnedQuestion["id"]) : ?>
                                        <div class="collapse" id="collapse<?php echo $pinnedQuestion["id"] ?>">
                                            <div class="card card-body">
                                                <?php echo  $comment["userName"] . ": " . $comment["comment"] ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="" name="comment" placeholder="comment">
                                    <input type="hidden" value="<?php echo htmlspecialchars($pinnedQuestion["id"]) ?>" name="questionId"></input>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endforeach ?>

                <h3>Questions</h3>
                <!-- php for each questions as question-->
                <?php foreach ($questions as $question) : ?>
                    <!-- Questions cards-->
                    <?php if ($question['pinned'] == 0) : ?>
                        <form method="POST">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $question["userName"] ?></h5>
                                    <p class="card-text"><?php echo $question["question"] ?></p>
                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?php echo $question["id"] ?>" aria-expanded="false" aria-controls="collapse<?php echo $question["id"] ?>">
                                        Opmerkingen
                                    </button>

                                    <?php if ($user[0]['admin'] == 1) : ?>
                                        <form method="POST">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="pin" <?php if ($question['pinned'] == 1) : echo "checked";
                                                                                                            endif ?>>
                                                <label class="form-check-label" for="pin">
                                                    Pin
                                                </label>
                                                <input type="hidden" value="<?php echo htmlspecialchars($question["id"]) ?>" name="questionId"></input>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    <?php endif ?>

                                    <!-- php for each comments as comment-->
                                    <?php foreach ($comments as $comment) : ?>
                                        <?php if ($comment['forum_question_id'] == $question["id"]) : ?>
                                            <div class="collapse" id="collapse<?php echo $question["id"] ?>">
                                                <div class="card card-body">
                                                    <p><?php echo  $comment["userName"] . ": " . $comment["comment"] ?></p>
                                                    <p class="voteNumber"><?php echo $comment["votes"] ?><span class="vote" data-id="<?php echo $comment["id"] ?>"></span></p>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" name="comment" placeholder="comment">
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
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="./css/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
</body>

<script>
    $("#sendMessage").on("click", function(e) {
        let chat_message = $('#message').val();

        $.ajax({
            url: 'ajax/sendMessage.php',
            type: 'POST',
            data: {
                chat_message: chat_message
            },
            success: function(response) {
                console.log(response);
            }
        });

        e.preventDefault();
    });

    $(".vote").on("click", function(e) {
        let id = $(this).data("id");

        $.ajax({
            url: 'ajax/upvote.php',
            type: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
            }
        });
    });
</script>

</html>