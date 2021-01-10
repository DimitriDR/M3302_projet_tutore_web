<?php
/**
 * @version 1.0 Reviewed and compliant file
 */

require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/order.php";
require_once dirname(__DIR__) . "/models/user.php";

/* On vérifie les paramètres */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["flash"]["danger"] = "Le paramètre est vide ou n'est pas valide.";
    header("Location: ../my_orders");
    exit;
}

$order = new Order();
$order->hydrate($_GET["id"]);

// On vérifie que l'ID d'un utilisateur d'une commande soit identique à celui de la personne connectée pour empêcher de changer le statut d'une commande qui ne vous appartient pas.
if ($order->get_id_user() != unserialize($_SESSION["user_information"])->get_id_user()) {
    $_SESSION["flash"]["danger"] = "Vous n'avez pas les droits pour effectuer cette action";
    header("Location: ../my_orders");
    exit;
}

$order->cancel_order();

// Une fois que tout est fini, on redirige
$_SESSION["flash"]["success"] = "Votre commande a bien été annulée.";
header("Location: ../my_orders");