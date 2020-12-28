<?php
require_once "../models/product.php";

// On vérifie que l'ID envoyé dans l'URL soit bien un entier
if(!is_numeric($_GET["id"])) {
    die("erreur");
}

// Si tout va bien, on créé un objet selon le numéro donné
$product = new Product();
$product->hydrate($_GET["id"]);