<?php
session_start();

// Si l'utilisateur clique sur le bouton Envoyer
if(isset($_POST["submit"])) {
    // On initialise un tableau contenant les erreurs
    $errors = array();

    // On récupère tous les champs
    $last_name = trim($_POST["last_name"]);
    $first_name = trim($_POST["first_name"]);
    $email_address = trim($_POST["email_address"]);
    $password = trim($_POST["password"]);
    $street_number = trim($_POST["street_number"]);
    $street_name = trim($_POST["street_name"]);
    $city = trim($_POST["city"]);
    $zip_code = trim($_POST["zip_code"]);
    $district = trim($_POST["district"]);
    $mobile_number = trim($_POST["mobile_number"]);

    // On vérifie que le nom ne soit ni vide, ni trop long (> 50)
    if(empty($last_name) || strlen($last_name) > 50) {
        $errors["empty_or_too_long_last_name"] = "Le nom est vide ou dépasse la limite autorisé (50 caractères maximum)";
    }

    // On vérifie que le prénom ne soit ni vide, ni trop long (> 50)
    if(empty($first_name) || strlen($first_name) > 50) {
        $errors["empty_or_too_long_first_name"] = "Le prénom est vide ou dépasse la limite autorisé (50 caractères maximum)";
    }


    // On met le tableau dans une session
    $_SESSION["register_errors"] = $errors;
    // Redirection vers le formulaire
    header("location:inscription.php");

}