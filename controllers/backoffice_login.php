<?php
session_start();

require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/user.php";

if (isset($_POST["submit"])) {
    if(!isset($_POST["password"]) || empty($_POST["password"])) {
        $_SESSION["flash"]["danger"] = "Veuillez saisir le mot de passe.";
        header("Location: ../backoffice_login");
        exit;
    }

    $databaselink = new DatabaseLink();
    $user_information = unserialize($_SESSION["user_information"]);

    // On récupère le mot de passe d'administration pour vérifier qu'il soit correct
    $get_password = $databaselink->make_query("SELECT `admin_password` FROM `users.rights` WHERE id_user = ?", [
        $user_information->get_id_user()
    ]);

    if(password_verify($_POST["password"], $get_password->fetchColumn())) {
        $_SESSION["administrator"] = true;
        $_SESSION["flash"]["success"] = "Vous êtes désormais connecté en tant qu'administrateur";
        header("Location: ../backoffice_index");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = "Le mot de passe saisie est incorrect.";
        header("Location: ../backoffice_login");
        exit;
    }
}