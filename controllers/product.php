<?php
session_start();

require_once dirname(__DIR__) . "/models/product.php";

// On vérifie que l'ID envoyé dans l'URL soit bien un entier
if(empty($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["flash"]["warning"] = "L'ID du produit est vide ou invalide";
    header("Location: ../index.php");
    exit;
}

// Si tout va bien, on créé un objet selon le numéro donné
$product = new Product();
$product->hydrate($_GET["id"]);