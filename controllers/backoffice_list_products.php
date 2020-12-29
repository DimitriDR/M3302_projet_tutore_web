<?php
// Démarrage d'une session
session_start();

// On inclut le fichier contenant le modèle du produit
require_once dirname(__DIR__) . "/models/product.php";

$product = new Product();

function display_all_products() : void {
    $databaselink = new DatabaseLink();
    $query = $databaselink->make_query("SELECT `id_product` FROM products");
    $fetch_product = $query->fetchAll();

    foreach ($fetch_product as $product_line) {
        $product = new Product();
        $product->hydrate($product_line->id_product);

        echo "<tr>";
        echo "<td>". $product->get_label() ."</td>";
        echo "<td>". $product->get_type() ."</td>";
        echo "<td>". $product->get_season() ."</td>";
        echo "<td>". $product->get_classification() ."</td>";
        echo "<td>". $product->get_price() ."</td>";
        echo "<td><a href='backoffice_edit_product.php?id=".$product->get_id_product()."' class='btn btn-outline-success'><i class='far fa-pen fa-xs'></i></a><a href='delete_product.php?id=".$product->get_id_product()."' class='btn btn-outline-danger'><i class='far fa-trash-alt fa-xs'></i></a></td>";
        echo "</tr>";
    }
}