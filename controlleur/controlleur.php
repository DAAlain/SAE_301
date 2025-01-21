<?php
require_once "modele/bdd.php";

function login($mail,$mdp){
    if (isset($_POST["ok"])){
        $nom_utilisateur = $mail;
        $mot_de_passe = $mdp;

        $requete = "SELECT * FROM compte WHERE Mail=?;";
        $data = $nom_utilisateur;
        
        $donnees = execReqPrep($requete,array($data));
        
        if($donnees){
            if(password_verify($mot_de_passe, $donnees["mdp"])){
                $_SESSION["nom"] = $donnees["Nom"];
                if ($donnees["autorisation"] == "0"){
                header("Location: index.php?acces=normal");
                }
                if ($donnees["autorisation"] == "1"){
                header("Location: index.php?acces=admin");
                }
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

function quitter(){
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header("Location: index.php");
}

function ajout(){
    if (isset($_POST["ruche"])){
        $nom= $_SESSION["nom"];
        $nom_ruche= $_POST["nom_ruche"];
        $id_ruche= $_POST["id_ruche"];
        $requete_ruche = "INSERT INTO demande_ruche VALUES('$id_ruche','$nom','$nom_ruche',NOW(),'en attente')";
        ajoutBDD($requete_ruche);
    }
}

function demandes(){
    $requete = "SELECT * FROM demande_ruche WHERE etat='en attente'";
    $demandes = execReq($requete);
    return $demandes;
}

function demande_gerer(){
    if (isset($_POST["action"])){
        $demande_id = $_POST["demande_id"];
        if ($_POST["action"] === "accepter"){
            $requete = "SELECT * FROM demande_ruche WHERE id = ?";
            $data = [$demande_id];
            $demande = execReqPrep($requete, $data);

            $requete_ajout = "INSERT INTO ruche VALUES(?,?,?)";
            $data_ajout = [$demande["id"],$demande["nom_compte"],$demande["nom_ruche"]];
            ajoutBDDPrep($requete_ajout, $data_ajout);
        }
        $requete_delete = "DELETE FROM demande_ruche WHERE id=?";
        $data_delete = [$demande_id];
        deleteligne($requete_delete, $data_delete);
    }
}