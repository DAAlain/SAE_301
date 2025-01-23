<?php
require_once "modele/bdd.php";

function login($mail, $mdp)
{
    if (isset($_POST["ok"])) {
        $nom_utilisateur = $mail;
        $mot_de_passe = $mdp;

        $requete = "SELECT * FROM compte WHERE Mail=?;";
        $data = $nom_utilisateur;

        $donnees = execReqPrep($requete, array($data));

        if ($donnees) {
            if (password_verify($mot_de_passe, $donnees["mdp"])) {
                $_SESSION["nom"] = $donnees["Nom"];
                $_SESSION["id"] = $donnees["id"];
                if ($donnees["autorisation"] == "0") {
                    header("Location: index.php?acces=normal");
                }
                if ($donnees["autorisation"] == "1") {
                    header("Location: index.php?acces=admin");
                }
            } else {
                echo "Mot de passe incorrect";
            }
        } else {
            echo "Nom d'utilisateur introuvable";
            require "vue/vueinscription.php";
        }
    }
}

function register($Nom, $Mail, $Mdp)
{
    if (isset($Nom))
        $name = $Nom;
    if (isset($Mail))
        $email = $Mail;
    if (isset($Mdp))
        $MDP = password_hash($Mdp, PASSWORD_DEFAULT);
    $requeteajout = "INSERT INTO compte (Nom,Mail,mdp,autorisation) VALUES('$name','$email','$MDP',0)";
    ajoutBDD($requeteajout);
}

function quitter()
{
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header("Location: index.php");
}

function ajout()
{
    if (isset($_POST["ruche"])) {
        $nom = $_SESSION["nom"];
        $nom_ruche = $_POST["nom_ruche"];
        $id_ruche = $_POST["id_ruche"];
        $id_compte = $_SESSION["id"];
        $requete_ruche = "INSERT INTO demande_ruche VALUES('$id_ruche','$id_compte','$nom','$nom_ruche',NOW(),'en attente')";
        ajoutBDD($requete_ruche);
    }
}

function demandes()
{
    $requete = "SELECT * FROM demande_ruche WHERE etat='en attente'";
    $demandes = execReq($requete);
    return $demandes;
}

function demande_gerer()
{
    if (isset($_POST["action"]) && isset($_POST["demande_id"])) {
        $demande_id = $_POST["demande_id"];

        // Récupérer d'abord les informations de la demande
        $requete = "SELECT * FROM demande_ruche WHERE id = ?";
        $data = [$demande_id];
        $demande = execReqPrep($requete, $data);

        if ($demande) {  // Vérifier si la demande existe
            if ($_POST["action"] === "accepter") {
                $requete_ajout = "INSERT INTO ruche VALUES(?,?,?,?)";
                $data_ajout = [$demande["id"], $demande["id_compte"], $demande["nom_compte"], $demande["nom_ruche"]];
                ajoutBDDPrep($requete_ajout, $data_ajout);
            }

            // Supprimer la demande après traitement
            $requete_delete = "DELETE FROM demande_ruche WHERE id=?";
            $data_delete = [$demande_id];
            deleteligne($requete_delete, $data_delete);

            // Rediriger vers la page des ruches pour rafraîchir l'affichage
            header("Location: index.php?acces=ruches");
            exit();
        }
    }
}

function admin_users()
{
    // Récupère tous les utilisateurs avec autorisation = 0
    $requete = "SELECT * FROM compte WHERE autorisation = 0";
    $users = execReq($requete);
    return $users;
}

function get_ruches_by_user($user_id)
{
    $requete = "SELECT * FROM ruche WHERE id_compte = ?";
    $connexion = connexionBDD();
    $stmt = $connexion->prepare($requete);
    $stmt->execute(array($user_id));
    $ruches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $ruches;
}

function delete_user($user_id)
{
    // Supprimer d'abord les ruches de l'utilisateur
    $requete_ruches = "DELETE FROM ruche WHERE id_compte = ?";
    $connexion = connexionBDD();
    $stmt = $connexion->prepare($requete_ruches);
    $stmt->execute(array($user_id));

    // Puis supprimer l'utilisateur
    $requete_user = "DELETE FROM compte WHERE id = ?";
    $stmt = $connexion->prepare($requete_user);
    $stmt->execute(array($user_id));
}

function delete_ruche($ruche_id)
{
    $requete = "DELETE FROM ruche WHERE id = ?";
    $connexion = connexionBDD();
    $stmt = $connexion->prepare($requete);
    $stmt->execute(array($ruche_id));
}
