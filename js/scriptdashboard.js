const ajoutruche=document.getElementById("ajoutruche");
if (ajoutruche){
    ajoutruche.addEventListener("click",function() {
        document.getElementById("formajoutruche").style.display = 'block';
    });
};

const ajoutruche2=document.getElementById("ajoutruche2");
if (ajoutruche2){
    ajoutruche2.addEventListener("click",function() {
        document.getElementById("formajoutruche").style.display = 'block';
    });
};

const quitter=document.querySelector(".quitter");
if (quitter){
    quitter.addEventListener("click",function() {
        document.getElementById("formajoutruche").style.display = 'none';
    });
};

const fermer=document.getElementById("fermer");
if (fermer){
    fermer.addEventListener("click",function() {
        document.getElementById("formajoutruche").style.display = 'none';
    });
};

