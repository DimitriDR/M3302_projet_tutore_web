<?php
// On vérifie que le paramètre du token soit bien présent
if(!isset($_GET["token"]) || !is_string($_GET["token"])) {
    $_SESSION["flash"]["warning"] = "Le paramètre est vide ou invalide.";
    header("Location: ../index");
    exit;
}

// On vérifie que le token corresponde à celui généré à la connexion
if(hash_equals($_GET["token"], $_SESSION["user_token"])) {
    // Dans ce cas on détruit les sessions
    unset($_SESSION["user_information"]);
    unset($_SESSION["user_token"]);

    // Pour l'administrateur, on déconnecte également les droits
    if(isset($_SESSION["administrator"])) {
        unset($_SESSION["administrator"]);
    }

    session_destroy();

    $_SESSION["flash"]["success"] = "Vous avez été déconnecté avec succès.";
    header("Location: index");
} else {
    // Sinon, on ne déconnecte pas
    $_SESSION["flash"]["danger"] = "Le token donné en paramètre est invalide. Déconnexion impossible.";
    header("Location: index");
}
