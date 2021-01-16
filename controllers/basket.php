<?php
/**
 * @version 1.0 Reviewed and compliant file
 */
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/basket.php";
require_once dirname(__DIR__) . "/models/databaselink.php";

// On récupère tous les produits disponibles
$database_link = new DatabaseLink();
$basket = new Basket();

if(!$basket->initialization()) {
    $_SESSION["flash"]["warning"] = "Une erreur s'est produite lors de la récupération du panier.";
    header("Location: " . $GLOBALS["forwarding"]);
    exit;
}