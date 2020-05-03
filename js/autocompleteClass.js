//auto complete lokaal vinder
var autocompleteclass = document.querySelector("#autocompleteClass");

//autocompleteclass.style.display = "none";

document.querySelector('#searchClass').addEventListener("keyup", event => {
        let input = document.querySelector('#searchClass').value;
        console.log("gelukt");
        let formData = new FormData();
        formData.append("text",input);

        fetch('autocompleteclass.php', {
            method: "POST",
            body: formData
        }).then(response => response.json())
        .then(result => {
            console.log(result.body);
            autocompleteclass.style.display = "block";
            autocompleteclass.innerHTML = "";
            result.body.forEach(element => {
                let suggestion = document.createElement('a');
                suggestion.innerHTML = element.classRoom;
                suggestion.setAttribute("href", "/class.finder.php?searchField="+element.classRoom+"&searchClass=Zoek");
                autocompleteclass.appendChild(suggestion);
            });
        }).catch( error => {
            console.log("Error:", error);
        
        });
});
// browser denkt standaard HTML code terug te krijgen
// hierbij json teruggeven 
// ons js kent geen php arrays, wel json
// lijn 13: antwoord parsen in json formaat
// geven daaronder json antwoord door als result
