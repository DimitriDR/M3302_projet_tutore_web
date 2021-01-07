<?php
require_once "common.start.session.php";
require_once "common.forwarding.php";

require_once dirname(__DIR__) . "/models/product.php";

// On vérifie qu'un ID soit donné et que ce soit un nombre, sinon, une erreur
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["flash"]["warning"] = "Le paramètre est vide ou invalide.";
    header("Location: ". $GLOBALS["forwarding"]);
    exit;
}

// Si tout est bon, on créé un nouveau produit
$product = new Product();
$successfully_hydrate = $product->hydrate($_GET["id"]);

// Si on s'aperçoit que notre produit n'existe pas, ou qu'il y a eu une erreur quelconque
if(!$successfully_hydrate) {
    unset($product);
    $_SESSION["flash"]["danger"] = "Le produit n'a pas pû être récupéré (peut-être parce-que l'ID correspond au produit n'existe pas...).";
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
    $label = trim($_POST["label"]);
    $image = $_FILES["image"];
    $price = floatval($_POST["price"]);
    $unit = trim($_POST["unit"]);
    $season = trim($_POST["season"]);
    $classification = $_POST["classification"];
    $type = trim($_POST["type"]);
    $description = trim($_POST["description"]);

    // Traitement du libellé
    if (empty($label)) {
        $errors["empty_label"] = "Il faut renseigner un libellé";
    } else if (!preg_match("/^([a-zA-Zéàè\s])*$/", $label)) { // Seul les lettres sont acceptés
        $errors["not_valid_label"] = "Le libellé ne peut être composé que de lettres et d'espaces";
    }

    // DÉBUT - Traitement de l'image
    // Si l'image n'a pas été déposée, on considère qu'on ne la change pas, sinon, on la traite comme si on l'ajoutait pour la première fois
    $authorized_image_types = array(
        "png",
        "jpg",
        "jpeg",
        "webp"
    );

    $authorized_image_mime_types = array(
        "image/png",
        "image/jpeg",
        "image/webp"
    );

    // Récupération de l'extension
    $file_extension = null;
    // Récupération du VRAI type de l'image
    $file_mime_type = null;

    if (is_uploaded_file($image["tmp_name"])) {
        $file_extension = pathinfo($image["name"], PATHINFO_EXTENSION);
        $file_mime_type = mime_content_type($image["tmp_name"]);
        if ((!in_array($file_extension, $authorized_image_types)) || (!in_array($file_mime_type, $authorized_image_mime_types))) {
            $errors["invalid_type"] = "Le format de l'image n'est pas autorisé (webp, jpg, jpeg, et png uniquement)";
        }
    } else {
        $image = null;
    }
    // FIN - Traitement de l'image

    // Traitement du prix
    if (empty($price)) {
        $errors["empty_price"] = "Il faut renseigner un prix";
    } else if (!preg_match("/^[0-9.]+$/", $price)) {
        // On accepte des chiffres suivi, faculativement d'une virgule puis de nombres
        $errors["not_valid_price"] = "Le prix doit uniquement être composé de nombres et d'une virgule";
    } else if($price <= 0) {
        $errors["negative_price"] = "Le prix ne peut être négatif ou nul";
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
    } else if (!in_array(mb_strtolower($classification), $classification_list)) {
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
        $product->update_product($label, $type, $classification, $description, $price, $season, $unit, $image, $file_extension);

        // On finalise
        $_SESSION["flash"]["success"] = "Le produit a été mis à jour avec succès";
        header("Location: ../backoffice_list_products");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("Location: ../backoffice_edit_product?id=".$_GET["id"]);
        exit;
    }
}