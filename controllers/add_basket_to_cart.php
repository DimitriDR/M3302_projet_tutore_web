<?php
// Fichiers nécessaires
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
// Modèles nécessaires
require_once dirname(__DIR__) . "/models/basket.php";
require_once dirname(__DIR__) . "/models/cart.php";
//require_once dirname(__DIR__) . "/models/databaselink.php";

// On vérifie si l'utilisateur est connecté car seul un utilisateur authentifié peut ajouter un produit au panier
if(!isset($_SESSION["user_information"]) || empty($_SESSION["user_information"])) {
    $_SESSION["flash"]["warning"] = "Vous devez être connecté pour ajouter un panier composé à votre panier.";
    header("Location: /login");
    exit;
}

// On récupère tous les produits disponibles
$database_link = new DatabaseLink();
$basket = new Basket();
$basket->initialization();

// Désérialisation du panier
$cart = unserialize($_SESSION["cart"]);
$cart->add_basket($basket);

$_SESSION["cart"] = serialize($cart);

$_SESSION["flash"]["success"] = "Le panier composé a bien été ajouté au panier.";
header("Location: /");