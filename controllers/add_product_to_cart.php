<?php
// Démarrage de la session
session_start();

if (isset($_POST["add"])) {
    // On vérifie que l'ID envoyé dans l'URL soit bien un entier
    if (empty($_POST["id"]) || !is_numeric($_POST["id"])) {
        $_SESSION["flash"]["danger"] = "L'ID du produit est vide ou invalide";
        header("Location: ../index.php");
        exit;
    }

    // Fichiers nécessaires
    require_once dirname(__DIR__) . "/models/cart.php";
    require_once dirname(__DIR__) . "/models/product.php";

    // Désérialisation du panier
    $cart = unserialize($_SESSION["cart"]);

    // On récupère toutes les informations du produit
    $this_product = new Product();
    $this_product->hydrate($_POST["id"]);

    $cart->add_item($this_product);

     // On doit résérialiser l'objet
     $_SESSION["cart"] = serialize($cart);
     $_SESSION["flash"]["success"] = "Le produit a été ajouté avec succès.";
     header("Location: ". $_SERVER["HTTP_REFERER"]);
}