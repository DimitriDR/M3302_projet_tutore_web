<?php
/**
 * @version 1.0 Reviewed and compliant file
 */

require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/cart.php";
require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/user.php";

// Si on a déjà une session utilisateur, on redirige
if(!empty($_SESSION["user_information"])) {
    $_SESSION["flash"]["info"] = "Vous êtes déjà connecté";
    header("Location: /");
    exit;
}

// Traitement du formulaire de connexion
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

    $user = new User();

    // On vérifie que le mot de passe ne soit pas vide et composé d'au moins 8 caractères
    if (empty($password)) {
        $errors["empty_or_too_short_password"] = "Le mot de passe est vide";
    } else if(!$user->check_credentials($email_address, $password)) {
        $errors["wrong_credentials"] = "L'adresse ou le mot de passe sont incorrects";
    }

    // Si le tableau des erreurs est vide, alors on peut commencer l'insertion
    if (empty($errors)) {
            $database_link = new DatabaseLink();

            // On hydrate l'objet User
            $user->login($email_address);

            // On met cet objet dans la session
            $_SESSION["user_information"] = serialize($user);
            // Et on créé aussi un nouveau panier
            $_SESSION["cart"] = serialize(new Cart());

            // On termine
            $_SESSION["flash"]["success"] = "Vous êtes désormais connecté.";
            header("location: /");
            exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("location: ". $GLOBALS["forwarding"]);
        exit;
    }
}