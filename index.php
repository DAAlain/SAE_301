<?php
session_start();
require "config/config.php";
require "controlleur/controlleur.php";

if (isset($_SESSION["nom"])){
    require "vue/vuedashboard.php";

    if (isset($_GET["action"])){
        if ($_GET["action"] == "quitter")
            quitter();
    }
}
else{
    if(isset($_GET["action"])){

        if ($_GET["action"] == "login")
            login($_POST["mail"],$_POST["mdp"]);

        if ($_GET["action"] == "register"){
            register($_POST["Nom"],$_POST["Mail"],$_POST["Mdp"]);
            require "vue/vueinscription.php";
        }
            
        if ($_GET["action"] == "inscription"){
            require "vue/vueinscription.php";
        }

        if ($_GET["action"] == "connexion"){
            require "vue/vueinscription.php";
        }
        
    }
    else
        require "vue/vueaccueil.php";
}