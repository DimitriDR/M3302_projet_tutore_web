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
    header("Location: ../index.php");
    exit;
}

/***********************************/
/**** Soumissions du formulaire ****/
/***********************************/

if (isset($_POST["submit"])) {
    // Création d'un tableau vide contenant toutes les erreurs
    $errors = array();

    // On récupère toutes les variables du formulaire
    $label = trim($_POST["label"]);
    $season = trim($_POST["season"]);
    $classification = trim($_POST["classification"]);
    $description = trim($_POST["description"]);
    $price = (float)$_POST["price"];

    // Traitement du libellé
    if (empty($label)) {
        $errors["empty_label"] = "Il faut renseigner un libellé";
    } else if (!preg_match("/^([a-zA-Zéàè\s])*$/", $label)) { // Seul les lettres sont acceptés
        $errors["not_valid_label"] = "Le libellé ne peut être composé que de lettres et d'espaces";
    }

    // Traitement du prix
    if (empty($price)) {
        $errors["empty_price"] = "Il faut renseigner un prix";
    } else if (!preg_match("/^[0-9\.]+$/", $price)) {
        // On accepte des chiffres suivi, faculativement d'une virgule puis de nombres
        $errors["not_valid_price"] = "Le prix doit uniquement être composé de nombres et d'une virgule";
    }

    // Traitement de la saison
    $season_list = array(
        "Hiver",
        "Printemps",
        "Été",
        "Automne",
    );

    if (empty($season)) {
        // Ne devrait pas arriver car c'est une liste, mais on ne sait jamais...
        $errors["empty_season"] = "Il faut renseigner une saison";
    } else if (!in_array($season, $season_list)) {
        // On évite que des modifications dans le HTML ne donne lieu à des incohérentes dans la BD
        $errors["not_valid_season"] = "La saison choisie n'est pas valide";
    }

    // Traitement de la classification
    $classification_list = array(
        "composées",
        "ombellifères",
        "liliacées",
        "légumineuses",
        "chénopodiacées",
        "cucurbitacées",
        "solanacées",
        "labiées",
        "crucifères",
        "autres"
    );

    if (empty($classification)) {
        // Ne devrait pas arriver car c'est une liste, mais on ne sait jamais...
        $errors["empty_classificaiton"] = "Il faut renseigner une classification";
    } else if (!in_array(strtolower($classification), $classification_list)) {
        // On évite que des modifications dans le HTML ne donne lieu à des incohérentes dans la BD
        $errors["not_valid_classification"] = "La classification choisie n'est pas valide";
    }

    // Traitement de la description
    if (empty($description)) {
        $errors["empty_description"] = "Il faut renseigner une description";
    }

    // Si on n'a aucune erreur, on peut enregister
    if (empty($errors)) {
        $product->update($_GET["id"], $label, $season, $classification, $description, $price);

        // On finalise
        $_SESSION["flash"]["success"] = "Le produit a été mis à jour avec succès";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("Location: ../edit_product.php?id=".$_GET["id"]);
        exit;
    }
}