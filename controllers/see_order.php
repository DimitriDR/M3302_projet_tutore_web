<?php
require_once "common.start.session.php";
require_once "common.forwarding.php";

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/user.php";
require_once dirname(__DIR__) . "/models/order.php";
require_once dirname(__DIR__) . "/models/product.php";

/* On vérifie les paramètres */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["flash"]["danger"] = "Le paramètre est vide ou n'est pas valide.";
    header("Location: ../my_orders");
    exit;
}

// On récupère la commande lié à l'ID dans l'URL
$order = new Order();
$order->hydrate($_GET["id"]);

// On vérifie que l'ID d'un utilisateur d'une commande soit identique à celui de la personne connectée pour empêcher de changer le statut d'une commande qui ne vous appartient pas.
if ($order->get_id_user() != unserialize($_SESSION["user_information"])->get_id_user()) {
    $_SESSION["flash"]["danger"] = "Vous n'avez pas les droits pour effectuer cette action";
    header("Location: ../my_orders");
    exit;
}


/*
$database_link = new DatabaseLink();

$delivery_query = $database_link->make_query("SELECT `id_order` FROM `orders` WHERE id_user = ? ORDER BY id_order DESC LIMIT 0,1", [unserialize($_SESSION["user_information"])->get_id_user()]);
$delivery_fetch = $delivery_query->fetchColumn();

if($database_link->number_of_returned_rows($delivery_query) === 0) {
    $_SESSION["flash"]["warning"] = "Impossible d'afficher votre dernière commande car aucune n'a été passée.";
    header("Location: ". $GLOBALS["forwarding"]);
    exit;
}

$order = new Order();
$order->hydrate($delivery_fetch);

function display_all_products() : void {
    $database_link = new DatabaseLink();

    $delivery_query = $database_link->make_query("SELECT `id_order` FROM `orders` WHERE id_user = ? ORDER BY id_order DESC LIMIT 0,1", [unserialize($_SESSION["user_information"])->get_id_user()]);
    $delivery_fetch = $delivery_query->fetchColumn();

    $order = new Order();
    $order->hydrate($delivery_fetch);

    $product_query = $database_link->make_query("SELECT `id_product` FROM products_orders NATURAL JOIN products WHERE id_order = ?", [$order->get_id_order()]);
    $product_fetch = $product_query->fetchAll();

    foreach ($product_fetch as $product_line) {
        $product = new Product();
        $product->hydrate($product_line->id_product);

        echo "<li>". $product->get_label() ."</li>";
    }
}*/