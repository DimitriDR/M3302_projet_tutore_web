<?php
require_once "common.start.session.php";
require_once "common.forwarding.php";

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/cart.php";
require_once dirname(__DIR__) . "/models/product.php";

// Si aucun n'argument, ni POST, ni GET n'a été donné, on ne peut rien faire, donc on redirige
if (!isset($_POST["add"]) && !isset($_GET["id"])) {
    $_SESSION["flash"]["danger"] = "Une erreur est survenue lors de l'ajout au panier.";
    if(isset($_SERVER["HTTP_REFERER"])) {
        header("Location: ". $GLOBALS["forwarding"]);
    } else {
        header("Location: /");
    }
    exit;
}

// On vérifie si l'utilisateur est connecté car seul un utilisateur authentifié peut ajouter un produit au panier
if(!isset($_SESSION["user_information"]) || empty($_SESSION["user_information"])) {
    $_SESSION["flash"]["warning"] = "Vous devez être connecté pour ajouter un produit à votre panier.";
    header("Location: /login");
    exit;
}

$id = 0;

// On vérifie que l'ID envoyé dans l'URL soit bien un entier, mais on adapte selon la méthode d'envoi
if(!empty($_POST)) {
    if (empty($_POST["id"]) || !is_numeric($_POST["id"])) {
        $_SESSION["flash"]["danger"] = "L'ID du produit est vide ou invalide.";
        header("Location: /");
        exit;
    }

    $id = (int) $_POST["id"];
} else {
    if(!is_numeric($_GET["id"])) {
        $_SESSION["flash"]["danger"] = "L'ID du produit est vide ou invalide.";
        header("Location: /");
        exit;
    }

    $id = (int) $_GET["id"];
}

// Désérialisation du panier
$cart = unserialize($_SESSION["cart"]);

// On récupère toutes les informations du produit
$this_product = new Product();
$successfully_retrieved_product = $this_product->hydrate($id);

// On s'assure que le produit existe avant de l'ajouter
if(!$successfully_retrieved_product) {
    $_SESSION["flash"]["danger"] = "Le produit que vous souhaitez ajouter n'existe pas.";
    header("Location: ". $GLOBALS["forwarding"]);
    exit;
}

$cart->add_item($this_product);

// On doit résérialiser l'objet
$_SESSION["cart"] = serialize($cart);
$_SESSION["flash"]["success"] = "Le produit a été ajouté avec succès.";
header("Location: ". $GLOBALS["forwarding"]);