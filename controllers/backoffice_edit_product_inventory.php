<?php
// Démarrage d'une session
session_start();

require_once dirname(__DIR__) . "/models/product.php";

// On vérifie qu'un ID soit donné et que ce soit un nombre, sinon, une erreur
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["flash"]["warning"] = "Le paramètre est vide ou invalide.";
    header("Location: ../index.php");
}

// Si tout est bon, on créé un nouveau produit
$product = new Product();
$successfully_hydrate = $product->hydrate($_GET["id"]);

// Si on s'aperçoit que notre produit n'existe pas, ou qu'il y a eu une erreur quelconque
if(!$successfully_hydrate) {
    unset($product);
    $_SESSION["flash"]["danger"] = "Le produit n'a pas pû être récupéré (peut-être parce-que l'ID correspond à un produit qui n'existe pas...).";
    header("Location: ../backoffice_index");
    exit;
}


/***********************************/
/**** Soumissions du formulaire ****/
/***********************************/

if (isset($_POST["submit"])) {
    // Création d'un tableau vide contenant toutes les erreurs
    $errors = array();

    // On récupère toutes les variables du formulaire
    $quantity = trim($_POST["quantity"]);
    $discount_rate= trim($_POST["discount_rate"]);

    // Traitement de la quantité
    if (empty($quantity)) {
        $quantity = 0;
    } else if(!is_numeric($quantity)) {
        $errors["not_numeric_quantity"] = "La quantité doit être une valeur numérique";
    }

    // Traitement de la quantité
    if (empty($discount_rate)) {
        $discount_rate = 0;
    } else if(!is_numeric($discount_rate)) {
        $errors["not_numeric_discout"] = "Le taux de promotion doit être une valeur numérique";
    }

    // Si on n'a aucune erreur, on peut enregister
    if (empty($errors)) {
        $product->update_inventory($_GET["id"], $quantity, $discount_rate);

        // On finalise
        $_SESSION["flash"]["success"] = "Le stock du produit a été mis à jour avec succès.";
        header("Location: ../backoffice_list_products");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("Location: ../backoffice_edit_product_inventory?id=".$_GET["id"]);
        exit;
    }
}