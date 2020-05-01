
var sugesstionBox = document.querySelector("#suggesstionBox");

sugesstionBox.style.display = "none";

document.querySelector("#searchName").addEventListener("keyup", event => {
    let input = document.querySelector("#searchName").value;
    console.log("haha");
    let formData = new FormData();
    formData.append("text", input);

    fetch('ajax/autocomplete.php', {
        method: "POST", 
        body: formData
    }).then(response => response.json())
    .then(result => {
        console.log(result.body);
        sugesstionBox.style.display = "block";
        sugesstionBox.innerHTML= "";
        result.body.forEach(element => {
            let suggestion = document.createElement('p');
            suggestion.innerHTML = element.Firstname + " " + element.lastName;
            sugesstionBox.appendChild(suggestion);
        });
    }).catch( error => {
        console.log("Error", error);
        
    });
});

