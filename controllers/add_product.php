<?php
require_once "/models/product.php";

// Si l'utilisateur clique sur le bouton "Ajouter un produit"
if(isset($_POST["submit"])) {
    $label = trim($_POST["label"]);
    $season = trim($_POST["season"]);
    $classification = trim($_POST["classification"]);
    $description = trim($_POST["description"]);
    $price = (float) $_POST["price"];

    $product = new Product();
    $product->add($label, $season, $classification, $description, $price);
}