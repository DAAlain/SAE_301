<?php
require_once "modele/bdd.php";

function login($mail,$mdp){
    if (isset($_POST["ok"])){
        $nom_utilisateur = $mail;
        $mot_de_passe = $mdp;

        $requete = "SELECT * FROM compte WHERE Mail=?;";
        $data = $nom_utilisateur;
        
        $donnees = execReq($requete,array($data));
        
        if($donnees){
            if(password_verify($mot_de_passe, $donnees["mdp"])){
                $_SESSION["nom"] = $donnees["Nom"];
                header("Location: index.php");
            }
            else {
                echo "Mot de passe incorrect";
            }
        }
        else {
            echo "Nom d'utilisateur introuvable";
            require "vue/vueinscription.php";
        }
    }
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