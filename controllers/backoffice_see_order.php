<?php
/**
 * Ce fichier permet de récupérer les informations nécessaires pour afficher le commande en détails.
 * @param string ID d'une commande donné grâce à la méthode GET
 * @version 1.0 Reviewed and compliant file
 */

require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/order.php";
require_once dirname(__DIR__) . "/models/user.php";

// On s'assure qu'on ait bien un paramètre valide dans l'URL
if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["flash"]["danger"] = "Le paramètre est soit manquant, vide, ou n'est pas un chiffre.";
    header("Location: ". $GLOBALS["forwarding"]);
    exit;
}

$order = new Order();
$has_successfully_hydrate = $order->hydrate($_GET["id"]);

if(!$has_successfully_hydrate) {
    $_SESSION["flash"]["warning"] = "Le contenu de la commande n'a pas pu être récupéré.";
    header("Location: ". $GLOBALS["forwarding"]);
    exit;
}

$database_link = new DatabaseLink();
$customer_query = $database_link->make_query("SELECT `email_address` FROM `users` WHERE `id_user` = ?", [$order->get_id_user()]);

// On récupère indirectement tout ce qui concerne l'utilisateur
$customer = new User();
$customer->login($customer_query->fetchColumn());

// On récupère aussi les produits dans la commande
$product_query = $database_link->make_query("SELECT `id_product`, `quantity` FROM `products_orders` WHERE `id_order` = ?", [$_GET["id"]]);
$all_products = $product_query->fetchAll();