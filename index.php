<?php
session_start();
require "config/config.php";
require "controlleur/controlleur.php";

if (isset($_SESSION["nom"])){
    require "vue/vuedashboard.php";
}
else{
    if(isset($_GET["action"])){
        if ($_GET["action"] == "login")
            login($_POST["nom"],$_POST["mdp"]);
        if ($_GET["action"] == "inscription"){
            require "vue/vueinscription.php";
        }
    }
    else
        require "vue/vueaccueil.php";
}