<?php
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/models/databaselink.php";

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
    $database_link = new DatabaseLink();
    $query = $database_link->make_query("UPDATE `orders` SET status = ? WHERE id_order = ?", [$_GET["status"], $_GET["id"]]);

    if(!$query) {
        $_SESSION["flash"]["danger"] = "Une erreur s'est produite lors de la mise à jour.";
    } else {
        $_SESSION["flash"]["success"] = "Le statut de la commande a bien été mis à jour.";
    }

    header("Location: ../backoffice_list_orders");
    exit;
}