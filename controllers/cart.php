<?php
session_start();

// On s'assure que l'utilisateur soit connecté pour accéder au panier
if(!isset($_SESSION["user_information"])) {
    $_SESSION["flash"]["warning"] = "Vous devez être inscrit et connecté pour passer commande.";
    header("Location: ../register.php");
    exit;
}

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/cart.php";
require_once dirname(__DIR__) . "/models/product.php";


function display_all_items() : void {
    foreach (unserialize($_SESSION["cart"])->get_items() as $item => $quantity) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo unserialize($item)->get_label() . " (". $quantity . ")";
        echo "<span>" . unserialize($item)->get_price() * $quantity .  "€ (unit. " . unserialize($item)->get_price() . " €)</span>";
        echo "</li>";
    }
}

function display_final_price() : float {
    return unserialize($_SESSION["cart"])->get_total_price();
}