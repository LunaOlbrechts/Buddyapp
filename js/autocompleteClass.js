//auto complete lokaal vinder

var autocompleteClass = document.querySelector("#autocompleteClass");

document.querySelector('#searchClassInField').addEventListener("keyup", event => {
        let input = document.querySelector('#searchClassInField').value;
        console.log('gelukt');

        let formData = new FormData();
        formData.append("searchField",input);

        fetch("ajax/autocompleteclass.php", {
            method: "GET",
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                console.log("Succes:", result);
                autocompleteClass.style.display = "block";
                result.FormData.forEach(element => {
                    let autocomplete = document.createElement('div');
                    autocomplete.innerHTML = element.firstName + "" + element.lastName;
                    autocompleteClass.appendChild(autocomplete);
                });
            })
            .catch(error => {
                console.error("Error:", error);
            });

});
// browser denkt standaard HTML code terug te krijgen
// hierbij json teruggeven 
// ons js kent geen php arrays, wel json
// lijn 13: antwoord parsen in json formaat
// geven daaronder json antwoord door als result
