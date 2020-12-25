<?php
session_start();

// Si l'utilisateur appuie sur le bouton pour soumettre le formulaire
if(isset($_POST["submit"])) {
    // On initialise un tableau contenant les erreurs
    $errors = array();

    $email_address = trim($_POST["email_address"]);
    $password = trim($_POST["password"]);

    // Si l'un des champs est vide, on envoie une erreur
    if(empty($email_address) || empty($password)) {
        $errors["empty_field"] = "Un des champs n'a pas été rempli";
    }

    // Si le tableau ne contient aucune erreur, on peut tenter de connecter l'utilisateur
    if(empty($errors)) {
        require_once "../model/DatabaseLink.php";
        require_once "../model/User.php";

        $user = new User();

        if($user->check_login($email_address, $password)) {
            $user->login();

            $_SESSION["flash"]["success"] = "Vous avez été connecté avec succès.";
            // header("Location: ../view/index.php");
        } else {
            $_SESSION["flash"]["warning"] = "Adresse e-mail ou mot de passe incorrects.";
            // header("Location: ../view/login.php");
        }
    }
}