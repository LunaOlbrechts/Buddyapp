class app{
    constructor(){
        this.btnMatch = document.querySelector("#match");
        this.btnMatch.addEventListener("click", this.matchBuddy.bind(this) );
    }

    matchBuddy(e){
        e.preventDefault();
        
    }
}