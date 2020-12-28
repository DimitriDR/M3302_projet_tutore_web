<?php
// Démarrage de la session
session_start();

// Fichiers nécessaires
require_once "../models/databaselink.php";
require_once "../models/user.php";

// Traitement du formulaire d'inscription
if (isset($_POST["submit"])) {
    // On initialise un tableau contenant les erreurs
    $errors = array();

    // On récupère tous les champs
    $email_address = trim($_POST["email_address"]);
    $password = trim($_POST["password"]);

    // On vérifie que l'adresse e-mail ne soit pas vide
    if (empty($email_address)) {
        $errors["email_address_empty"] = "L'adresse e-mail est vide";
    }

    // On vérifie que le mot de passe ne soit pas vide et composé d'au moins 8 caractères
    if (empty($password)) {
        $errors["empty_or_too_short_password"] = "Le mot de passe est vide";
    }

    $database_link = new DatabaseLink();
    $user = new User();

    if(!empty($password) && !$user->check_credentials($email_address, $password)) {
        $errors["wrong_credentials"] = "L'adresse ou le mot de passe sont incorrects";
    }

    // Si le tableau des erreurs est vide, alors on peut commencer l'insertion
    if (empty($errors)) {
            // On hydrate l'objet User
            $user->login($email_address);

            // On met cet objet dans la session
            $_SESSION["user_information"] = serialize($user);
            $_SESSION["user_token"] = $user->create_token();

            // On termine
            $_SESSION["flash"]["success"] = "Vous êtes désormais connecté";
            header("location: /index.php");
            exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("location: /login.php");
        exit;
    }
}