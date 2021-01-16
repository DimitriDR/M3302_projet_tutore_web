<?php
/**
 * @version 1.0 Reviewed and compliant file
 */
require_once dirname(__DIR__) . "/models/databaselink.php";

// On va afficher 3 produits qui sont le plus en stock en avant sur la page d'accueil
$database_link = new DatabaseLink();
$query = $database_link->make_query("SELECT `id_product` FROM `products` NATURAL JOIN `products.inventory` ORDER BY `quantity` DESC LIMIT 0,3");
$fetch = $query->fetchAll();