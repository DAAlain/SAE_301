<?php
session_start();
require "config/config.php";
require "controlleur/controlleur.php";

if (isset($_SESSION["nom"])){
    header("Location: vue/vuedashboard.php");
}
else{
    if(isset($_GET["action"])){
        if ($_GET["action"] == "login")
            login($_POST["nom"],$_POST["mdp"]);
    }
    else
        header("Location: vue/vueaccueil.php");
}