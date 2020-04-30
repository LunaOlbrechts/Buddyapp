$(".emoji").on("click", function(e) {
    let clickedEmoji = this.innerHTML;
    let reaction = $(this).parent().parent().find(".reaction");
    $(reaction).text(clickedEmoji);
    let message = $(this).parent().parent();
    let id = message.data("messageid");
    
    $.ajax({
       url: 'ajax/saveemoji.php',
       type: 'POST',
       data: {
          emoji: clickedEmoji,
          id: id
       },
       success: function (response) {
          console.log(response);
       }
    });
 });
 
 $(".message").on('mouseover', function(){
   $(this).find("ul").css("visibility", "visible");
});
 
 $(".message").mouseleave(function() {
   $(".emojis").css("visibility", "hidden");
});