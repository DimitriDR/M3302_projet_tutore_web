<?php
require_once "common.start.session.php";

// On inclut le fichier contenant le modèle du produit
require_once dirname(__DIR__) . "/models/order.php";

function are_orders() : bool {
    $database_link = new DatabaseLink();

    $order_query = $database_link->make_query("SELECT `id_order` FROM `orders` WHERE `id_user` = ?", [unserialize($_SESSION["user_information"])->get_id_user()]);

    if($database_link->number_of_returned_rows($order_query) === 0) {
        return false;
    }

    return true;
}
/**
 * Fonction permettant de lister toutes les commandes de l'utilisateur courant
 */
function display_all_orders() : void {
    $database_link = new DatabaseLink();

    $order_query = $database_link->make_query("SELECT `id_order` FROM `orders` WHERE `id_user` = ?", [unserialize($_SESSION["user_information"])->get_id_user()]);
    $order_fetch = $order_query->fetchAll();

    foreach ($order_fetch as $order_line) {
        $order = new Order();
        $order->hydrate($order_line->id_order);

        echo "<tr>";
        echo "<td>". date("d/m/Y à H:i:s", strtotime($order->get_date())) ."</td>";
        echo "<td>". $order->get_status() ."</td>";
        echo "<td>
                <a href='/controllers/see_order?id=". $order_line->id_order ."' class='btn btn-outline-primary'><i class='fad fa-eye fa-xs'></i> Voir la commande</a>
                <a href='/controllers/cancel_order?id=". $order_line->id_order ."' class='btn btn-outline-danger'><i class='fad fa-ban fa-xs'></i> Annuler la commande</a>
                </td>";
        echo "</tr>";
    }
}