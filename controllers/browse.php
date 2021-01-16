<?php
/**
 * @version 1.0 Reviewed and compliant file
 */
require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/models/product.php";

// On récupère tous les produits disponibles
$database_link = new DatabaseLink();
$product_query = $database_link->make_query("SELECT `id_product` FROM `products` NATURAL JOIN `products.inventory` WHERE `quantity` > 0");
$products = $product_query->fetchALl();