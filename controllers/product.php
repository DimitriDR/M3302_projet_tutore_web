<?php
// On démarre sur session, sauf si une est déjà ouverte
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/product.php";

// On vérifie que l'ID envoyé dans l'URL soit bien un entier
if(empty($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["flash"]["warning"] = "L'ID du produit est vide ou invalide.";
    header("Location: ". $_SERVER["HTTP_REFERER"]);
    exit;
}

// On vérifie dans la base de données que l'ID demandé existe
$database_link = new DatabaseLink();
$query = $database_link->make_query("SELECT `id_product` FROM `products` WHERE `id_product` = ?", [$_GET["id"]]);

if($database_link->number_of_returned_rows($query)) {
    $product = new Product();
    $product->hydrate($_GET["id"]);
} else {
    $_SESSION["flash"]["warning"] = "L'ID du produit donné ne correspond à aucun produit.";
    header("Location: /");
    exit;
}