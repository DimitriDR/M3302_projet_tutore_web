<?php
require_once "common.start.session.php";
require_once "common.forwarding.php";

// Fichiers nécessaires
require_once dirname(__DIR__) . "/models/cart.php";
require_once dirname(__DIR__) . "/models/basket.php";
require_once dirname(__DIR__) . "/models/order.php";
require_once dirname(__DIR__) . "/models/product.php";
require_once dirname(__DIR__) . "/models/user.php";

// On s'assure que l'utilisateur soit connecté pour accéder au panier
if (!isset($_SESSION["user_information"])) {
    $_SESSION["flash"]["warning"] = "Vous devez être inscrit et connecté pour passer commande.";
    header("Location: ../register.php");
    exit;
}

// On vérifie que le panier ne soit pas vide
if (unserialize($_SESSION["cart"])->get_number_of_items() === 0) {
    $_SESSION["flash"]["dark"] = "Le panier ne peut être affiché si vous n'avez ajouté aucun article.";
    header("Location: " . $GLOBALS["forwarding"]);
    exit;
}

/**
 * Fonction pour afficher l'ensemble des articles du panier sous la forme d'une liste
 */
function display_all_items(): void {
    foreach (unserialize($_SESSION["cart"])->get_items() as $item => $quantity) {

        // Si c'est un panier, on oublie

            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
            echo unserialize($item)->get_label() . " (" . $quantity . ")";
            echo "<span>" . unserialize($item)->get_discounted_price() * $quantity . "€ (unit. " . unserialize($item)->get_discounted_price() . " €)</span>";
            echo "</li>";

//        } else {
//            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
//            echo "Panier composé";
//            echo "</li>";
//        }
    }
}

/**
 * Fonction affichant le nombre total d'articles dans le panier et affiche ou non un "s" ;)
 */
function display_number_of_items() : string {
    $number_of_items = unserialize($_SESSION["cart"])->get_number_of_items();

    if ($number_of_items <= 1) {
        return "(" . $number_of_items . " article)";
    } else {
        return "(" . $number_of_items . " articles)";
    }
}

/****************************/
/* Traitement du formulaire */
/****************************/

if (isset($_POST["submit"])) {
    // Tableau contenant les erreurs
    $errors = array();

    // On récupère l'utilisateur courant contenu dans la session pour être réutilisé plus facilement
    $user = unserialize($_SESSION["user_information"]);

    // Si une information de la session est vide, alors les informations demandées sont manquantes
    if ($user->are_attributes_empty()) {
        $errors["missing_information"] = "Le panier ne peut être validé. Assurez-vous d'avoir rempli tous les champs sur <a href='../edit_my_banking_information' target='_blank'><i class='fad fa-external-link-square-alt fa-xs'></i> cette page</a> et <a href='../edit_my_information' target='_blank'><i class='fad fa-external-link-square-alt fa-xs'></i> cette page</a>";
    }

    // On peut commencer par créer un nouvel objet Order
    $order = new Order();

    // On vérifie qu'il soit possible d'enregistrer une nouvelle commande.
    // C'est impossible si une commande est en attente avec le même numéro utilisateur
    if (!$order->is_possible($user->get_id_user())) {
        $errors["unconfirmed_order_exists"] = "Il semblerait que vous ayez déjà une commande encore non validée par le producteur.";
    }

    // Une fois cette étape passée, on peut créer un nouvel objet Cart
    $cart = new Cart();

    // On doit vérifier s'il y a assez de stock
    if(!$cart->enough_supply()) {
        $errors["not_enough"] = "Il semblerait que l'un des articles que vous souhaitez n'ait pas assez de stock. Veuillez ajuster la quantité.";
    }

    // Si on n'a aucune erreur, alors on peut enregistrer la commande.
    if(empty($errors)) {
        // On enregistre la commande avec l'ID de l'utilisateur donné et en retour, cela nous donne l'ID de la commande qui vient d'être inséré
        $last_id_order = $order->register($user->get_id_user(), unserialize($_SESSION["cart"])->get_final_amount());

        // On enregistre tous les produits
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
        $_SESSION["flash"]["warning"] = $errors;
        header("location: ". $GLOBALS["forwarding"]);
        exit;
    }
}