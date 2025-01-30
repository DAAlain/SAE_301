<?php
require_once "modele/bdd.php";

function login($mail, $mdp)
{
    $nom_utilisateur = $mail;
    $mot_de_passe = $mdp;

    $requete = "SELECT * FROM compte WHERE Mail=?;";
    $data = $nom_utilisateur;

    $donnees = execReqPrep($requete, array($data));

    if ($donnees) {
        if (password_verify($mot_de_passe, $donnees["mdp"])) {
            $_SESSION["nom"] = $donnees["Nom"];
            $_SESSION["id"] = $donnees["id"];
            $_SESSION["photo_profil"] = $donnees["photo_profil"] ?? 'default.png';
            
            $response = ['success' => true];
            if ($donnees["autorisation"] == "0") {
                $response['redirect'] = 'index.php?acces=normal';
            } else if ($donnees["autorisation"] == "1") {
                $response['redirect'] = 'index.php?acces=admin';
            }
            echo json_encode($response);
            exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'Mot de passe incorrect']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => "Cette adresse email n'existe pas"]);
        exit;
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

function get_ruches()
{
    $requete = "SELECT * FROM ruche";
    $connexion = connexionBDD();
    $stmt = $connexion->query($requete);
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

function update_photo() {
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'assets/img/profiles/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
            // Supprimer l'ancienne photo
            if (!empty($_SESSION['photo_profil']) && $_SESSION['photo_profil'] !== 'default.png') {
                $old_photo = $upload_dir . $_SESSION['photo_profil'];
                if (file_exists($old_photo)) {
                    unlink($old_photo);
                }
            }
            
            // Mettre à jour la base de données
            $connexion = connexionBDD();
            $requete = "UPDATE compte SET photo_profil = ? WHERE id = ?";
            $stmt = $connexion->prepare($requete);
            $stmt->execute([$new_filename, $_SESSION['id']]);
            
            // Mettre à jour la session
            $_SESSION['photo_profil'] = $new_filename;
        }
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}