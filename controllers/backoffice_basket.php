<?php
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/basket.php";
require_once dirname(__DIR__) . "/models/databaselink.php";

/***********************************************************/
/* Récupération de tous les produits que l'on peut ajouter */
/***********************************************************/
$database_link = new DatabaseLink();
$query = $database_link->make_query("SELECT `id_product` FROM `products`");
$fetch = $query->fetchAll();

/****************************/
/* Traitement du formulaire */
/****************************/
if(isset($_POST["submit"])) {
    // Création d'un tableau vide contenant toutes les erreurs
    $errors = array();

    // On récupère toutes les variables du formulaire
    $price = floatval($_POST["price"]);
    $products = $_POST["products"];

    // Traitement des produits
    if(empty($products)) {
        $errors["empty_products"] = "Aucun produit n'a été sélectionné";
    }

    // Traitement du prix
    if(empty($price)) {
        $errors["empty_price"] = "Le prix n'a pas été renseigné ou n'est pas valide";
    } else if($price <= 0) {
        $errors["negative_price"] = "Le prix ne peut pas être négatif";
    }

    if(empty($errors)) {
        $basket = new Basket();
        $basket->create($price, $products);
        
        $_SESSION["flash"]["success"] = "Le panier a bien été créé.";
        header("Location: ../backoffice_index");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("Location: ../backoffice_basket");
        exit;
    }
}