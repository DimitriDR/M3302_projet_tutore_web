<?php
/**
 * @version 1.0 Reviewed and compliant file
 */
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/cart.php";
require_once dirname(__DIR__) . "/models/user.php";

// On s'assure que l'utilisateur soit connecté
if(!isset($_SESSION["user_information"]) || empty($_SESSION["user_information"])) {
    $_SESSION["flash"]["info"] = "Impossible d'effectuer cette action si vous n'êtes pas connecté.";
    header("Location: /");
    exit();
}

// On s'assure que le panier ait été initialisé
if(!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    $_SESSION["flash"]["info"] = "Impossible d'effectuer cette action si le panier n'a pas été créé.";
    header("Location: /");
    exit();
}
unset($_SESSION["cart"]);
$_SESSION["cart"] = serialize(new Cart());

$_SESSION["flash"]["success"] = "Le panier a bien été vidé.";
header("Location: /");