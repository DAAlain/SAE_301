<?php
require_once "modele/bdd.php";

function login($nom,$mdp){
    if($mdp == MDP){
        $_SESSION["nom"] = $nom;
        header("Location: index.php");
    }  
    else
        require "vue/vueinscription.php";  
}

function register($Nom,$Mail,$Mdp){
    if (isset($Nom))
        $name = $Nom;
    if (isset($Mail))
        $email = $Mail;
    if (isset($Mdp))
        $MDP = password_hash($Mdp, PASSWORD_DEFAULT);
    $requeteajout= "INSERT INTO compte VALUES('$name','$email','$MDP',0)";
    ajoutBDD($requeteajout);
}