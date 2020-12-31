<?php
require_once "common.start.session.php";

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/cart.php";
require_once dirname(__DIR__) . "/models/product.php";

// On s'assure que l'utilisateur soit connecté pour accéder au panier
if (!isset($_SESSION["user_information"])) {
    $_SESSION["flash"]["warning"] = "Vous devez être inscrit et connecté pour passer commande.";
    header("Location: ../register.php");
    exit;
}

// On vérifie que le panier ne soit pas vide
if(unserialize($_SESSION["cart"])->get_number_of_items() === 0) {
    $_SESSION["flash"]["dark"] = "Le panier ne peut être affiché si vous n'avez ajouté aucun article.";
    header("Location: ". $_SERVER["HTTP_REFERER"]);
    exit;
}

/**
 * Fonction pour afficher l'ensemble des articles du panier sous la forme d'une liste
 */
function display_all_items(): void {
    foreach (unserialize($_SESSION["cart"])->get_items() as $item => $quantity) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo unserialize($item)->get_label() . " (" . $quantity . ")";
        echo "<span>" . unserialize($item)->get_price() * $quantity . "€ (unit. " . unserialize($item)->get_price() . " €)</span>";
        echo "</li>";
    }
}

/**
 * Fonction affichant le nombre total d'articles dans le panier et affiche ou non un "s" ;)
 */
function display_number_of_items(): void {
    $number_of_items = unserialize($_SESSION["cart"])->get_number_of_items();

    if ($number_of_items <= 1) {
        echo "(" . $number_of_items . " article)";
    } else {
        echo "(" . $number_of_items . " articles)";
    }
}

/****************************/
/* Traitement du formulaire */
/****************************/

if (isset($_POST["submit"])) {
    // Tableau contenant les erreurs
    $errors = array();

    // Si une information de la session est vide, alors les informations demandées sont manquantes
    if(empty($_SESSION["user_information"])) {
        $errors["missing_information"] = "Le panier ne peut être validé. Assurez-vous d'avoir rempli tous les champs sur <a href='../edit_my_banking_information' target='_blank'><i class='fad fa-external-link-square-alt fa-xs'></i> cette page</a> et <a href='../edit_my_information' target='_blank'><i class='fad fa-external-link-square-alt fa-xs'></i> cette page</a>";
    }

    if (empty($errors)) {
        // Fichiers nécessaires
        require_once dirname(__DIR__) . "/models/databaselink.php";
        require_once dirname(__DIR__) . "/models/order.php";
        require_once dirname(__DIR__) . "/models/user.php";

        // On récupère l'ID de l'utilisateur pour être plus facile dans les requêtes
        $id_user = unserialize($_SESSION["user_information"])->get_id_user();

        // Création des nouveaux objets nécessaires
        $database_link = new DatabaseLink();
        $order = new Order();

        // On enregistre la commande avec l'ID de l'utilisateur donné et en retour, cela nous donne l'ID de la commande qui vient d'être inséré
        $last_id_order = $order->register($id_user);

        $cart = new Cart();
        $cart->save_products_in_DB($_SESSION["cart"], $last_id_order);

        // On détruit le panier car il est traité
        unset($_SESSION["cart"]);

        // Mais on en reconstruit un vide si le client veut recommander sur la même session
        $_SESSION["cart"] = serialize(new Cart());

        // On confirme que le compte a bien été créé
        $_SESSION["flash"]["success"] = "Merci pour votre commande, nous allons la traiter dès que possible !";
        header("location: /");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }
}