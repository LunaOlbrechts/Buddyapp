$(".vote").on("click", function () {
    console.log("hahah");
    let id = $(this).data("id");
    $actual = $(this).parent().find('.number').html();
    $new = Number($actual) + 1;
    $(this).parent().find('.number').html($new);
    $.ajax({
        url: 'upvote.php',
        type: 'POST',
        data: {
            id: id
        },
        success: function (response) {
            console.log(response);
        }
    });
});