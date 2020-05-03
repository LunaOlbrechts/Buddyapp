class app{
    constructor(){
        this.btnMatch = document.querySelector("#match");
        this.btnMatch.addEventListener("click", this.matchBuddy.bind(this) );
    }

    matchBuddy(e){
        e.preventDefault();
        
    }
}

$(document).ready(function() {
   $('#login').attr('disabled', 'disabled');
  
  $('#captcha_code').on('keyup', function(){
   var code = $('#captcha_code').val();
   
   if(code == '')
   {
    $('#login').attr('disabled', 'disabled');
   }
   else
   {
    $.ajax({
     url:'check_code.php',
     method:"POST",
     data:{code:code},
     success:function(data)
     {
      if(data == 'success')
      {
       $('#login').attr('disabled', false);
      }
      else
      {
       $('#login').attr('disabled', 'disabled');
      }
     }
    });
   }
  });
});   


document.querySelector("#username").addEventListener("blur", function(){
    let userName = document.querySelector("#username").value;
     // console.log(userName);

    if(userName != ''){

      $("#username_response").show();

      $.ajax({
         url: 'checkusername.php',
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
       url: 'checkemail.php',
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


$(document).ready(function() {
   $('#btnSignUp').attr('disabled', 'disabled');
   // add variabele to stock in the id password
   var password = document.getElementById("password")
   password.addEventListener('keyup', function() {
       checkPassword(password.value)
   })

   function checkPassword(password) {
       var strengthBar = document.getElementById('strength')
       var strength = 0
       if (password.match(/[a-z][A-Z]+/)) {
           strength += 1
       }
       if (password.match(/[0-9]+/)) {
           strength += 1
       }
       if (password.match(/[!@£$^&*()]+/)) {
           strength += 1
       }
       if (password.length > 5) {
           strength += 1
       }

       switch (strength) {
           case 0:
               strengthBar.value = 0;
               var signUp = false;
               break
           case 1:
               strengthBar.value = 40;
               var signUp = false;
               break
           case 2:
               strengthBar.value = 60;
               var signUp = false;
               break
           case 3:
               strengthBar.value = 80;
               var signUp = true;
               break
           case 4:
               strengthBar.value = 100;
               var signUp = true;
               break
       }


       if (password != '') {

          // console.log(signUp);
           $.ajax({
                url: 'checkpassword.php',
                type: 'post',
                data: {
                    signUpCheck: signUp
                },
                success: function(result) {
                   if (result == "success") {
                       $('#btnSignUp').attr('disabled', false);
                   } else {
                       $('#btnSignUp').attr('disabled', 'disabled');
                   }
                }
           });
       } else {
           $("#allowed").hide();
       }
   }
});

