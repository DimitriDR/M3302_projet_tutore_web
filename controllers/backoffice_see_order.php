<?php
/**
 * Ce fichier permet de récupérer les informations nécessaires pour afficher le commande en détails.
 * @param string ID d'une commande
 */

// Démarrage de la session si ce n'est pas déjà fait
require_once "common.start.session.php";
// Pour rediriger proprement
require_once "common.forwarding.php";

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/order.php";
require_once dirname(__DIR__) . "/models/user.php";

// On s'assure qu'on ait bien un paramètre valide dans l'URL
if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["flash"]["danger"] = "Le paramètre est soit manquant, vide, ou n'est pas un chiffre";
    header("Location: ". $GLOBALS["forwarding"]);
    exit;
}

$order = new Order();
$order->hydrate($_GET["id"]);

$database_link = new DatabaseLink();
$customer_query = $database_link->make_query("SELECT `email_address` FROM users WHERE id_user = ?", [$order->get_id_user()]);

// On récupère indirectement tout ce qui concerne l'utilisateur
$customer = new User();
$customer->login($customer_query->fetchColumn());

// On récupère aussi les produits dans la commande
$product_query = $database_link->make_query("SELECT `id_product`, `quantity` FROM products_orders WHERE id_order = ?", [$_GET["id"]]);
$all_products = $product_query->fetchAll();