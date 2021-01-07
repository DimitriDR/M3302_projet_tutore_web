<?php
require_once "common.start.session.php";
require_once "common.forwarding.php";

require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/user.php";

if(!empty($_SESSION["user_information"])) {
    $_SESSION["flash"]["info"] = "Vous avez déjà un compte chez nous car vous êtes actuellement connecté. <i class='fal fa-laugh-wink'></i>";
    header("Location: /");
    exit;
}

// Traitement du formulaire d'inscription
if (isset($_POST["submit"])) {
    // On initialise un tableau contenant les erreurs
    $errors = array();

    // On récupère tous les champs
    $last_name = trim($_POST["last_name"]);
    $first_name = trim($_POST["first_name"]);
    $email_address = trim($_POST["email_address"]);
    $password = trim($_POST["password"]);
    $street_name = trim($_POST["street_name"]);
    $city = trim($_POST["city"]);
    $zip_code = trim($_POST["zip_code"]);
    $district = trim($_POST["district"]);
    $mobile_number = trim($_POST["mobile_number"]);

    // On vérifie que le nom ne soit ni vide, ni trop long (> 50)
    if (empty($last_name) || strlen($last_name) > 50) {
        $errors["empty_or_too_long_last_name"] = "Le nom est vide ou dépasse la limite autorisé (50 caractères maximum)";
    }

    // On vérifie que le prénom ne soit ni vide, ni trop long (> 50)
    if (empty($first_name) || strlen($first_name) > 50) {
        $errors["empty_or_too_long_first_name"] = "Le prénom est vide ou dépasse la limite autorisé (50 caractères maximum)";
    }

    // On vérifie que l'adresse e-mail ne soit pas vide
    if (empty($email_address)) {
        $errors["email_address_empty"] = "L'adresse e-mail ne peut être vide";
    }

    // On vérifie le format de l'adresse e-mail
    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email_address)) {
        $errors["email_address_empty"] = "Le format de l'adresse e-mail ne correspond pas.";
    }

    // On vérifie que le mot de passe ne soit pas vide et composé d'au moins 8 caractères
    if (empty($password) || strlen($password) < 8) {
        $errors["empty_or_too_short_password"] = "Le mot de passe est vide ou fait moins de 8 caractères";
    }

    // On vérifie que le nom de la rue ne soit pas vide
    if (empty($street_name)) {
        $errors["empty_street_name"] = "Le nom de la rue doit être renseigné";
    }

    // On vérifie que la ville ne soit pas vide
    if (empty($city)) {
        $errors["empty_city"] = "Le nom de la ville doit être renseigné";
    }

    // On vérifie que le code postal :
    // - ne soit pas vide
    // - corresponde à 5 chiffres uniquement
    if (empty($zip_code) || !preg_match("/^[[:digit:]]{5}$/", $zip_code)) {
        $errors["empty_zip_code_or_not_valid"] = "Le code postal est vide ou ne respecte pas la norme (5 chiffres)";
    }

    // On vérifie que le quartier ne soit pas vide
    if (empty($district)) {
        $errors["empty_district"] = "Le quartier / arrondissement doit être renseigné";
    }

    // On vérifie que le numéro de portable ne soit pas vide et qu'il soit uniquement composé de 10 chiffres commençant par un 0
    if (empty($mobile_number) || !preg_match("/^([[:digit:]]){9}/", $mobile_number)) {
        $errors["empty_mobile_number_or_invalid"] = "Le numéro de téléphone est vide ou ne fait pas 9 caractères";
    }

    $database_link = new DatabaseLink();
    $user = new User();

    if($user->does_email_already_exist($email_address)) {
        $errors["email_address_already_exists"] = "Cette adresse e-mail est déjà utilisée";
    }

    // Si le tableau des erreurs est vide, alors on peut commencer l'insertion
    if (empty($errors)) {

        $user->register(strtoupper($last_name),
            ucfirst(strtolower($first_name)),
            $password,
            ucwords($street_name),
            $zip_code,
            ucwords($district),
            strtoupper($city),
            $mobile_number,
            strtolower($email_address)
        );
        
        // On confirme que le compte a bien été créé
        $_SESSION["flash"]["success"] = "Merci, votre inscription a été validée. Vous pouvez désormais <a href='/login'>vous connecter</a>.";
        header("location: /");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("location: ". $GLOBALS["forwarding"]);
        exit;
    }
}