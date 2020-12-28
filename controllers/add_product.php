<?php
session_start();

require_once dirname(__DIR__) . "/models/product.php";

// Si l'utilisateur clique sur le bouton "Ajouter un produit"
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
    } else if (!preg_match("/^([a-zA-Z\s])*$/", $label)) { // Seul les lettres sont acceptés
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
        "hiver",
        "printemps",
        "été",
        "automne",
    );

    if (empty($season)) {
        // Ne devrait pas arriver car c'est une liste, mais on ne sait jamais...
        $errors["empty_season"] = "Il faut renseigner une saison";
    } else if (!is_array(strtolower($season))) {
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
    } else if (!is_array(strtolower($classification))) {
        // On évite que des modifications dans le HTML ne donne lieu à des incohérentes dans la BD
        $errors["not_valid_classification"] = "La classification choisie n'est pas valide";
    }

    // Traitement de la description
    if(empty($description)) {
        $errors["empty_description"] = "Il faut renseigner une description";
    }

    // Si on n'a aucune erreur, on peut enregister
    if (empty($errors)) {
        // On créé un nouveau produit afin d'utiliser la méthode d'ajout intégrée
        $product = new Product();
        $product->add($label, $season, $classification, $description, $price);

        // On finalise
        $_SESSION["flash"]["success"] = "Le produit a été ajouté avec succès";
        header("Location: ../add_product.php");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("Location: ../add_product.php");
        exit;
    }
}