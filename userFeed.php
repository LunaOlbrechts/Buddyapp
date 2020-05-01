<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    #newPostContainer {
        display: none;
    }
</style>

<body>
    <?php include_once("include/nav.inc.php"); ?>
    <div class="container mt-5">
        <h1>Mijn posts</h1>
        <a id="newPost" class="btn btn-primary">Nieuwe Post</a>
        <div class="container">
            <div id="newPostContainer" class="container mt-3 p-0">
                <form method="POST" accept-charset="UTF-8">
                    <div class="form-group">
                        <label>Titel</label>
                        <input name="title" type="text" class="form-control" placeholder="Titel">
                    </div>
                    <div class="form-group">
                        <label>Post</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($data['description']) ?></textarea>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Plaats post" name="updateDetails">
                </form>
            </div>
        </div>
    </div>
    <?php include_once("include/footer.inc.php"); ?>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $('#newPost').on('click', function() {
        var click = $(this).data('clicks');

        if (click) {
            $("#newPostContainer").slideUp();
        } else {
            $("#newPostContainer").slideDown();
        };

        $(this).data('clicks', !click); // you have to set it

    });
</script>