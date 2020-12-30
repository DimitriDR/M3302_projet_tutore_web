<?php
// On démarre sur session, sauf si une est déjà ouverte
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/cart.php";
require_once dirname(__DIR__) . "/models/product.php";

// On s'assure que l'utilisateur soit connecté pour accéder au panier
if (!isset($_SESSION["user_information"])) {
    $_SESSION["flash"]["warning"] = "Vous devez être inscrit et connecté pour passer commande.";
    header("Location: ../register.php");
    exit;
}

// On vérifie également que le panier ne soit pas vide
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

    // Récupération de tous les champs
    $credit_card_name = trim($_POST["credit_card_name"]);
    $credit_card_number = trim($_POST["credit_card_number"]);
    $credit_card_ccv = trim($_POST["credit_card_security_number"]);
    $credit_card_expiration_date = trim($_POST["credit_card_expiration_date"]);

    // Vérification du nom de la carte
    if (empty($credit_card_name)) {
        $errors["empty_credit_card_name"] = "Le nom de la carte n'a pas été saisi";
    }

    // Vérification du numéro de la carte
    if (empty($credit_card_number)) {
        $errors["empty_credit_card_number"] = "Le numéro de la carte n'a pas été saisi";
    }

    // Vérification du code de la carte
    if (empty($credit_card_ccv)) {
        $errors["empty_credit_card_"] = "Le code de la carte n'a pas été saisi";
    } else if (!preg_match("/^[0-9]{3}$/", $credit_card_ccv)) {
        $errors["wrong_card_number"] = "Le code doit uniquement être composé de 3 chiffres";
    }

    // Vérification de la date de la carte
    if (empty($credit_card_expiration_date)) {
        $errors["empty_credit_card_expiration_date"] = "La date d'expiration de la carte n'est pas valide";
    }

    if (empty($errors)) {
        // Fichiers nécessaires
        require_once dirname(__DIR__) . "/models/databaselink.php";
        require_once dirname(__DIR__) . "/models/order.php";
        require_once dirname(__DIR__) . "/models/user.php";

        // On récupère l'id de l'utilisateur pour être plus facile dans les requêtes
        $id_user = unserialize($_SESSION["user_information"])->get_id_user();

        $database_link = new DatabaseLink();

        // On va d'abord insérer les données bancaires
        $payment_query = $database_link->make_query("INSERT INTO `users.payment` (id_user, name, number, ccv, expiration_date) VALUES(?, ?, ?, ?, ?)", [
            $id_user,
            $credit_card_name,
            $credit_card_number,
            $credit_card_ccv,
            $credit_card_expiration_date
        ]);

        $order = new Order();

        // On enregistre la commande avec l'ID de l'utilisateur donné et en retour, cela nous donne l'ID de la commande
        $last_id_order = $order->register($id_user);

        $cart = new Cart();
        $cart->save_products_in_DB($_SESSION["cart"], $last_id_order);

        // On détruit le panier car il est traité
        unset($_SESSION["cart"]);

        // Mais on en reconstruit un vide si le client veut recommander sur la même session
        $_SESSION["cart"] = serialize(new Cart());

        // On confirme que le compte a bien été créé
        $_SESSION["flash"]["success"] = "Merci pour votre commande, nous allons la traiter dès que possible !";
        header("location: /index");
        exit;
    } else {
        $_SESSION["flash"]["danger"] = $errors;
        header("location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }
}