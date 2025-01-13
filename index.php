<?php
session_start();
require "config/config.php";
require "controlleur/controlleur.php";

try{ 
    if (!isset($_SESSION))
        header ("Location: vue/vueaccueil.php");
}
catch (Exception $e) {

}
