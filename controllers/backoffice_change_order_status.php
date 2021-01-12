<?php
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/order.php";

// On s'assure d'avoir ce qu'il faut dans les paramètres
if (empty($_GET["id"]) || empty($_GET["status"]) || !is_numeric($_GET["id"]) || !is_numeric($_GET["status"])) {
    $_SESSION["flash"]["warning"] = "Un ou plusieurs paramètres sont manquants.";
    header("Location: " . $GLOBALS["forwarding"]);
    exit;
}

/****************************/
/* Traitement du formulaire */
/****************************/
if(isset($_POST["submit"])) {
    $id = intval($_GET["id"]);
    $status = intval($_GET["status"]);

    $order = new Order();
    $order->hydrate($_GET["id"]);
    $order->change_status($_GET["status"]);

    // Si c'est une confirmation, on retire du stock
    if($status === 1) {
        $order->remove_inventory();
    }

    $_SESSION["flash"]["success"] = "Le statut de la commande a bien été mis à jour.";
    header("Location: ../backoffice_list_orders");
}