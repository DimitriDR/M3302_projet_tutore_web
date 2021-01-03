<?php
require_once "common.start.session.php";
require_once "common.forwarding.php";
require_once dirname(__DIR__) . "/models/product.php";

/***********************************/
/**** Soumissions du formulaire ****/
/***********************************/

if (isset($_POST["submit"])) {
    // Création d'un tableau vide contenant toutes les erreurs
    $errors = array();

    // On récupère toutes les variables du formulaire
    $label = trim($_POST["label"]);
    $image = $_FILES["image"];
    $price = floatval($_POST["price"]);
    $unit = trim($_POST["unit"]);
    $season = trim($_POST["season"]);
    $classification = trim($_POST["classification"]);
    $type = trim($_POST["type"]);
    $description = trim($_POST["description"]);

    // Traitement du libellé
    if (empty($label)) {
        $errors["empty_label"] = "Il faut renseigner un libellé";
    } else if (!preg_match("/^([a-zA-ZéàèÉâ\s])*$/", $label)) { // Seul les lettres sont acceptés
        $errors["not_valid_label"] = "Le libellé ne peut être composé que de lettres et d'espaces";
    }

    // DÉBUT - Traitement de l'image
    $authorized_image_types = array(
        "png",
        "jpg",
        "jpeg",
        "webp"
    );

    // Récupération de l'extension
    $file_extension = pathinfo($image["name"], PATHINFO_EXTENSION);
    // Récupération du VRAI type de l'image
    $file_mime_type = mime_content_type($image["tmp_name"]);

    if (!is_uploaded_file($image["tmp_name"])) {
        $errors["empty_image"] = "Il faut mettre en ligne une image";
    } else if (!in_array($file_extension, $authorized_image_types)) {
        $errors["invalid_type"] = "Le format de l'image n'est pas autorisé (webp, jpg, jpeg, et png uniquement)";
    }

    // FIN - Traitement de l'image

    // Traitement du prix
    if (empty($price)) {
        $errors["empty_price"] = "Il faut renseigner un prix";
    } else if (!preg_match("/^[0-9.]+$/", $price)) {
        // On accepte des chiffres suivi, faculativement d'une virgule puis de nombres
        $errors["not_valid_price"] = "Le prix doit uniquement être composé de nombres et d'une virgule";
    }

    // Traitement de l'unité
    $unit_list = array(
        "Le kilo",
        "À la pièce",
    );

    if (empty($unit)) {
        // Ne devrait pas arriver car c'est une liste, mais on ne sait jamais...
        $errors["empty_unit"] = "Il faut renseigner une unité";
    } else if (!in_array($unit, $unit_list)) {
        // On évite que des modifications dans le HTML ne donne lieu à des incohérentes dans la BD
        $errors["not_valid_unit"] = "L'unité choisie n'est pas valide";
    }

    // Traitement de la saison
    $season_list = array(
        "Hiver",
        "Printemps",
        "Été",
        "Automne",
        "Toute l'année",
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
        "Autres",
        "Chénopodiacées",
        "Composées",
        "Crucifères",
        "Cucurbitacées",
        "Labiées",
        "Liliacées",
        "Légumineuses",
        "Ombellifères",
        "Solanacées"
    );

    if (empty($classification)) {
        // Ne devrait pas arriver car c'est une liste, mais on ne sait jamais...
        $errors["empty_classification"] = "Il faut renseigner une classification";
    } else if (!in_array($classification, $classification_list)) {
        // On évite que des modifications dans le HTML ne donne lieu à des incohérentes dans la BD
        $errors["not_valid_classification"] = "La classification choisie n'est pas valide";
    }

    // Traitement du type
    if (empty($type)) {
        // Ne devrait pas arriver car c'est une liste, mais on ne sait jamais...
        $errors["empty_type"] = "Il faut renseigner un type";
    } else if ($type != "Légumes" && $type != "Fruits") {
        // On évite que des modifications dans le HTML ne donne lieu à des incohérentes dans la BD
        $errors["not_valid_type"] = "Le type choisi n'est pas valide";
    }

    // Traitement de la description
    if (empty($description)) {
        $errors["empty_description"] = "Il faut renseigner une description";
    }

    // Si on n'a aucune erreur, on peut enregister
    if (empty($errors)) {
        // On créé un nouveau produit afin d'utiliser la méthode d'ajout intégrée
        $product = new Product();

        $product_id = $product->change($label, $type, $season, $classification, $description, $price, $unit, $image);

        // On peut mettre l'image sur le serveur
        move_uploaded_file($_FILES["image"]["tmp_name"], dirname(__DIR__) . "/views/assets/images/products/$label.$file_extension");

        // On finalise
        $_SESSION["flash"]["success"] = "Le produit a été ajouté avec succès. <strong>Néanmoins, il faut aller sur <a href='../backoffice_edit_product_inventory?id=" . $product_id . "'>cette page</a> pour saisir le stock, sans quoi, votre produit sera caché.</strong>";
        header("Location: ../backoffice_index");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("Location: " . $GLOBALS["forwarding"]);
        exit;
    }
}