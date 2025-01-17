<?php

function connexionBDD(){
    try{
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $database = new PDO('mysql:host='. DBHOST .';dbname='. DBNAME, DBUSER, DBMDP, $options);
    }
    catch (Exception $err){
        throw new Exception('Erreur connexion MYSQL');
    }
    return $database;
}

function ajoutBDD($requete){
    $bdd=connexionBDD();
    $ajout= $bdd->exec($requete);
    return $ajout;
}