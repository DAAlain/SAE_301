<?php
session_start();
require "config/config.php";
require "controlleur/controlleur.php";

if (isset($_SESSION["nom"])) {
    if (isset($_GET["acces"])) {
        if ($_GET["acces"] == "normal") {
            require "vue/vuedashboard.php";
        }
        if ($_GET["acces"] == "admin") {
            require "vue/vueadmin.php";
        }
        if ($_GET["acces"] == "ruches") {
            require "vue/vueruches.php";
        }
    }

    if (isset($_GET["action"])) {
        if ($_GET["action"] == "quitter") {
            quitter();
        }

        if ($_GET["action"] == "ajout") {
            ajout();
            require "vue/vuedashboard.php";
        }

        if ($_GET["action"] == "gerer") {
            demande_gerer();
        }

        if ($_GET["action"] == "update_photo") {
            update_photo();
        }

        if (isset($_GET['action']) && $_GET['action'] === 'get_ruches' && isset($_GET['acces']) && $_GET['acces'] === 'admin') {
            $ruches = get_ruches_by_user($_GET['user_id']);
            header('Content-Type: application/json');
            echo json_encode($ruches);
            exit();
        }

        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'delete_user':
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (isset($data['user_id'])) {
                        delete_user($data['user_id']);
                        echo json_encode(['success' => true]);
                    }
                    exit;

                case 'delete_ruche':
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (isset($data['ruche_id'])) {
                        delete_ruche($data['ruche_id']);
                        echo json_encode(['success' => true]);
                    }
                    exit;
            }
        }
    }

    if (isset($_GET["id"])) {
        require "vue/vuedashboard.php";
    }

    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 'statistiques':
                require 'vue/vuestatistiques.php';
                break;
            case 'dashboard':
            default:
                require 'vue/vuedashboard.php';
                break;
            case 'admin':
        }
    }
} else {
    if (isset($_GET["action"])) {

        if ($_GET["action"] == "login") {
            login($_POST["mail"], $_POST["mdp"]);
        }

        if ($_GET["action"] == "register") {
            register($_POST["Nom"], $_POST["Mail"], $_POST["Mdp"]);
            require "vue/vueinscription.php";
        }

        if ($_GET["action"] == "inscription") {
            require "vue/vueinscription.php";
        }

        if ($_GET["action"] == "connexion") {
            require "vue/vueinscription.php";
        }
    } else
        require "vue/vueaccueil.php";
}
