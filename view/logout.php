<?php
require_once "../model/User.php";

session_start();

if(!isset($_SESSION["user"])) {
    $_SESSION["flash"]["warning"] = "Vous ne pouvez pas être déconnecté car aucune session n'existe";
    header("Location: index.php");
}

// Si le token correspond, on valide la déconnexion, sinon il n'est pas bon
if(hash_equals($_SESSION["user_token"], $_GET["token"])) {
    $user = new User();
    $user->logout();

    $_SESSION["flash"]["success"] = "Vous avez été déconnecté avec succès";
    header("Location: index.php");
} else {
    $_SESSION["flash"]["danger"] = "La déconnexion n'a pas fonctionné car le token semble invalide.";
    header("Location: dashboard.php");
}
