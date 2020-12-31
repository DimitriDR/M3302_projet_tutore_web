<?php
require_once "common.start.session.php";

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/user.php";

// Traitement du formulaire d'inscription
if (isset($_POST["submit"])) {
    // On initialise un tableau contenant les erreurs
    $errors = array();

    // On récupère tous les champs
    $credit_card_name = trim($_POST["credit_card_name"]);
    $credit_card_number = trim($_POST["credit_card_number"]);
    $credit_card_security_number = trim($_POST["credit_card_security_number"]);
    $credit_card_expiration_date = trim($_POST["credit_card_expiration_date"]);

    // Traitement du champ nom
    if(empty($credit_card_name)) {
        $errors["empty_credit_card_name"] = "Le nom de la carte n'a pas été saisi";
    } else if(!preg_match("/^[[:alpha:]\s]+$/", $credit_card_name)) {
        $errors["not_valid_credit_card_name"] = "Le nom de la carte ne peut être uniquement composée de lettres et d'espaces";
    }

    // Traitement du numéro de la carte
    if(empty($credit_card_number)) {
        $errors["empty_credit_card_number"] = "Le numéro de la carte n'a pas été saisi";
    } else if(!preg_match("/^[[:digit:]-]+$/", $credit_card_number)) {
        $errors["not_valid_credit_card_number"] = "Le nom de la carte ne peut être uniquement composée de chiffres et de tirets";
    }

    // Traitement du CCV
    if(empty(unserialize($_SESSION["user_information"])->get_credit_card_security_number())) {
        if(empty($credit_card_security_number)) {
            $errors["empty_credit_card_cvv"] = "Le code de sécurité de la carte n'a pas été saisi";
        } else if(!preg_match("/^[[:digit:]]{3}$/", $credit_card_security_number)) {
            $errors["not_valid_cvv"] = "Le code de sécurité de la carte doit être uniquement composé de 3 chiffres";
        }
    }

    // Traitement de la date d'expiration
    if(empty($credit_card_expiration_date)) {
        $errors["empty_credit_card_expiration"] = "La date d'expiration de la carte n'a pas été saisi";
    }

    // Si le tableau des erreurs est vide, alors on peut commencer l'insertion
    if (empty($errors)) {
        require_once "../models/user.php";

        // La valeur du CCV dépend s'il est déjà stocké en BDD (donc dans la session)
        if(!empty(unserialize($_SESSION["user_information"])->get_credit_card_security_number()) && empty($credit_card_security_number)) {
            $credit_card_security_number = unserialize($_SESSION["user_information"])->get_credit_card_security_number();
        }

        // On met à jour dans la base de données
        unserialize($_SESSION["user_information"])->update_banking_information(unserialize($_SESSION["user_information"])->get_id_user(), $credit_card_name, $credit_card_number, $credit_card_security_number, $credit_card_expiration_date);

        // On mémorise l'e-mail pour pouvoir à nouveau récupérer les informations
        $email_addresss = unserialize($_SESSION["user_information"])->get_email_address();

        // Pour renouveler les informations dans la session, on va la détruire et la reconstruire.
        unset($_SESSION["user_information"]);
        $new_user = new User();
        $new_user->login($email_addresss);

        $_SESSION["user_information"] = serialize($new_user);

        // On confirme que le compte a bien été créé
        $_SESSION["flash"]["success"] = "Vos informations ont bien été mises à jour.";
        header("location: /edit_my_banking_information");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }
}