
class app{
    constructor(){
        this.btnMatch = document.querySelector("#match");
        this.btnMatch.addEventListener("click", this.matchBuddy.bind(this) );
    }

    matchBuddy(e){
        e.preventDefault();
        
    }
}


document.querySelector("#username").addEventListener("blur", function(){
    let userName = document.querySelector("#username").value;
     // console.log(userName);

    if(userName != ''){

      $("#username_response").show();

      $.ajax({
         url: '../Buddyapp/ajax/checkusername.php',
         type: 'post',
         data: {userName:userName},
         success: function(response){

            // Show response
            $("#username_response").html(response);

         }
      });
   }else{
      $("#username_response").hide();
   }

});

document.querySelector("#email").addEventListener("blur", function(){
  let email = document.querySelector("#email").value;
  // console.log(email);

  if(email != ''){

    $("#email_response").show();

    $.ajax({
       url: '../Buddyapp/ajax/checkemail.php',
       type: 'post',
       data: {email:email},
       success: function(response){

          // Show response
          $("#email_response").html(response);

       }
    });
 }else{
    $("#email_response").hide();
 }

});
     



