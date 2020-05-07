$(".vote").on("click", function () {
    console.log("hahah");
    let id = $(this).data("id");
    $actual = $(this).parent().find('.number').html();

    var click = $(this).data('clicks');

    if($(this).hasClass('voted')){
        if (click) {
            $.ajax({
                url: '/ajax/upvote.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (response) {
                    console.log(response);
                }
            });
            $new = Number($actual) + 1;
            $(this).parent().find('.number').html($new);
            $(this).addClass('on');
        }else{
            $(this).removeClass('on');
            $new = Number($actual) -1;
            $(this).parent().find('.number').html($new);

            $.ajax({
                url: 'downvote.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (response) {
                    console.log(response);
                }
            });
        };
    
        $(this).data('clicks', !click); // you have to set it
    } else {
        if (click) {
            $(this).removeClass('on');
            $new = Number($actual) -1;
            $(this).parent().find('.number').html($new);

            $.ajax({
                url: '/ajax/downvote.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (response) {
                    console.log(response);
                }
            });
        }else{
            $.ajax({
                url: '/ajax/upvote.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (response) {
                    console.log(response);
                }
            });
            $new = Number($actual) + 1;
            $(this).parent().find('.number').html($new);
            $(this).addClass('on');
        };
    
        $(this).data('clicks', !click); // you have to set it
    }
});