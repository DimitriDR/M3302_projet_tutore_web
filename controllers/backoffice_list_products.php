<?php
// On inclut le fichier contenant le modèle du produit
require_once dirname(__DIR__) . "/models/product.php";

$product = new Product();

function display_all_products() : void {
    $databaselink = new DatabaseLink();
    $query = $databaselink->make_query("SELECT `id_product`, `quantity`, `discount_rate` FROM `backoffice.products`");
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
        echo "<td>". $product_line->quantity ."</td>";
        echo "<td>". $product_line->discount_rate ." %</td>";
        echo "<td>
                <a href='backoffice_edit_product?id=".$product->get_id_product()."' class='btn btn-outline-primary'><i class='fad fa-edit fa-xs'></i> Édit. fiche prod.</a>
                <a href='backoffice_edit_product_inventory?id=".$product->get_id_product()."' class='btn btn-outline-secondary'><i class='fad fa-pallet fa-xs'></i> Modifier qtt.</a>
              </td>";
        echo "</tr>";
    }
}