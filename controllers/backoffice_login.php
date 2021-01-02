<?php
/**
 * @version 1.0 Reviewed and compliant file
 */

require_once "common.start.session.php";
require_once "common.forwarding.php";

require_once dirname(__DIR__) . "/models/user.php";

if (isset($_POST["submit"])) {
    if (!isset($_POST["password"]) || empty($_POST["password"])) {
        $_SESSION["flash"]["danger"] = "Veuillez saisir le mot de passe.";
        header("Location: " . $GLOBALS["forwarding"]);
        exit;
    }

    switch (unserialize($_SESSION["user_information"])->admin_login($_POST["password"])) {
        case -1:
            $_SESSION["flash"]["danger"] = "Vous n'avez pas les droits pour vous connecter ici.";
            header("Location: ../");
            exit;
        case 0:
            $_SESSION["administrator"] = true;
            $_SESSION["flash"]["success"] = "Vous êtes désormais connecté en tant qu'administrateur";
            header("Location: ../backoffice_index");
            break;
        case 1:
            $_SESSION["flash"]["warning"] = "Le mot de passe saisie est incorrect.";
            header("Location: ../backoffice_login");
            exit;
    }
}