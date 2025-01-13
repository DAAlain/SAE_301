<?php
function login($nom,$mdp){
    if($mdp == MDP){
        $_SESSION["nom"] = $nom;
        header("Location: index.php");
    }  
    else
        require "vue/vueinscription.php";  
}