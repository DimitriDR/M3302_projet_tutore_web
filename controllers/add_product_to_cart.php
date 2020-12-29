<?php
// Démarrage de la session
session_start();

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/cart.php";
require_once dirname(__DIR__) . "/models/product.php";

if (!isset($_POST["add"]) && !isset($_GET["id"])) {
    $_SESSION["flash"]["danger"] = "Une erreur est survenue lors de l'ajout au panier.";
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

$id = 0;

// On vérifie que l'ID envoyé dans l'URL soit bien un entier, mais on adapte selon la méthode d'envoi
if(!empty($_POST)) {
    if (empty($_POST["id"]) || !is_numeric($_POST["id"])) {
        $_SESSION["flash"]["danger"] = "L'ID du produit est vide ou invalide.";
        header("Location: ../index.php");
        exit;
    }

    $id = (int) $_POST["id"];
} else {
    if(!is_numeric($_GET["id"])) {
        $_SESSION["flash"]["danger"] = "L'ID du produit est vide ou invalide.";
        header("Location: ../index.php");
        exit;
    }

    $id = (int) $_GET["id"];
}

// Désérialisation du panier
$cart = unserialize($_SESSION["cart"]);

// On récupère toutes les informations du produit
$this_product = new Product();
$this_product->hydrate($id);

$cart->add_item($this_product);

// On doit résérialiser l'objet
$_SESSION["cart"] = serialize($cart);
$_SESSION["flash"]["success"] = "Le produit a été ajouté avec succès.";
header("Location: " . $_SERVER["HTTP_REFERER"]);