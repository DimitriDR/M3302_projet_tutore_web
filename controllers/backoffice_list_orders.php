<?php
require_once "common.start.session.php";
require_once dirname(__DIR__) . "/models/databaselink.php";

$databaselink = new DatabaseLink();
$query = $databaselink->make_query("SELECT * FROM `backoffice.orders`");
$fetch = $query->fetchAll();

/**
 * Fonction permettant de lister toutes les commandes
 */
//function display_all_orders() : void {
//    $databaselink = new DatabaseLink();
//
//    $query = $databaselink->make_query("SELECT * FROM `backoffice.orders`");
//    $fetch_order = $query->fetchAll();
//
//    foreach ($fetch_order as $order_line) {
//        $order = new Order();
//        $order->hydrate($order_line->id_order);
//
//        echo "<tr>";
//        echo "<td>". $order->get_id_order() ."</td>";
//        echo "<td><strong>". $order_line->last_name ."</strong> ". $order_line->first_name ."</td>";
//        echo "<td>". $order_line->street_name .", ". $order_line->city ."</td>";
//        echo "<td>". $order->get_date() ."</td>";
//        echo "<td>". $order->get_status() ."</td>";
//        echo "<td>";
//            echo "";
//        echo "</td>";
//        echo "</tr>";
//    }
//}