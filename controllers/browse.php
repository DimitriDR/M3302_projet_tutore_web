<?php

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/product.php";

// On récupère tous les produits disponibles
$databse_link = new DatabaseLink();
$product_query = $databse_link->make_query("SELECT `id_product` FROM `products`");

$products = $product_query->fetchALl();