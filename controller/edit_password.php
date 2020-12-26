<?php
session_start();
require_once "../model/DatabaseLink.php";
require_once "../model/User.php";

if (isset($_POST["submit"])) {
    // On initialise un tableau contenant les erreurs
    $errors = array();

    $new_password = trim($_POST["new_password"]);
    $new_password_confirmation = trim($_POST["new_password_confirmation"]);
    $old_password = trim($_POST["old_password"]);

    // Si l'un des champs est vide, on envoie une erreur
    if (empty($new_password) || empty($new_password_confirmation) || empty($old_password)) {
        $errors["empty_field"] = "Un des champs n'a pas été rempli";
    }

    if (strlen($new_password) < 8) {
        $errors["too_short"] = "Le mot de passe doit faire au moins 8 caractères";
    }

    if (!preg_match("/[a-zA-Z][0-9]/", $new_password)) {
        $errors["not_complex_enough"] = "Le mot de passe doit comporter au moins une lettre et un chiffre";
    }

    if ($new_password != $new_password_confirmation) {
        $errors["not_equal"] = "Les nouveaux mots de passe saisis ne sont pas identiques";
    }

    $user = new User();

    // Pour valider le changement de mot de passe, il faut vérifier que l'ancien soit bon
    if (!($user->check_password($_SESSION["user"]->id_user, $old_password))) {
        $errors["incorrect_password"] = "L'ancien mot de passe est incorrect";
    }

    // Si le tableau ne contient aucune erreur, on peut tenter de connecter l'utilisateur
    if (empty($errors)) {
        $user->change_password($_SESSION["user"]->id_user, $new_password_confirmation);
        $_SESSION["flash"]["success"] = "Le mot de passe a été changé avec succès";
        header("Location: ../view/dashboard.php");
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("Location: ../view/dashboard_edit_password.php");
    }
}