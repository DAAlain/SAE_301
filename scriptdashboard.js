const ajoutruche = document.getElementById("ajoutruche");
if (ajoutruche) {
    ajoutruche.addEventListener("click", function () {
        document.getElementById("formajoutruche").classList.add('active');
    });
};

const ajoutruche2 = document.getElementById("ajoutruche2");
if (ajoutruche2) {
    ajoutruche2.addEventListener("click", function () {
        document.getElementById("formajoutruche").classList.add('active');
    });
};

const quitter = document.querySelector(".quitter");
if (quitter) {
    quitter.addEventListener("click", function () {
        document.getElementById("formajoutruche").classList.remove('active');
    });
};

const fermer = document.getElementById("fermer");
if (fermer) {
    fermer.addEventListener("click", function () {
        document.getElementById("formajoutruche").classList.remove('active');
    });
}; 