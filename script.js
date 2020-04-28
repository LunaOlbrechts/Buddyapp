

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
     

    /*
    let formData = new FormData();

    formData.append('username', userName);

    fetch('../Buddyapp/ajax/checkusername.php', {
        method: 'POST',
        body: formData
    })
  .then((response) => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.blob();
  })
 
  .then((myBlob) => {
    userName.src = URL.createObjectURL(myBlob);
  })
  
  .catch((error) => {
    console.error('There has been a problem with your fetch operation:', error);
  });
   */  



