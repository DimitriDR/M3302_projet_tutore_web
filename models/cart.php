<?php
/**
 * Class Cart modélise un panier
 * @version 1.0 Reviewed and compliant file.
 */
class Cart {
    /* Attributs */
    /** @var array Tableau contenant les produits */
    private array $items = array();

    /** @var float Les frais d'une commande représente sont de 24,75% de son total */
    private const SHIPPING_PERCENTAGE = 24.75;

    /** @var int Taux de TVA, pour l'alimentaire, il est de 10% */
    private const VAT_PERCENTAGE = 10;

    /* Méthodes */
    /**
     * Méthode pour ajouter des produits au panier
     * @param Product $product Le produit à ajouter
     * @param int $quantity La quantité du produit à ajouter dans le panier
     */
    public function add_item(Product $product, int $quantity) : void {
        $serialized_product = serialize($product);

        // Si la quantité est négative, nulle, ou non renseignée, on ajoute 1 produit, sinon, le nombre désiré
        if ($quantity <= 0 || empty($quantity)) {
            $quantity = 1;
        }

        // On vérifie si l'article n'est pas déjà dans le panier (on vérifie sur les clés car le produit est stocké dans la clé)
        if (array_key_exists($serialized_product, $this->items)) {
            // Si c'est le cas, on va incrémenter la valeur du produit
            // Mais il faut d'abord récupérer la valeur correspondant à la bonne clé
            $this->items[$serialized_product] = $this->items[$serialized_product] + $quantity;
        } else {
            // Si ce n'est pas le cas, on va le mettre dans un tableau associatif et mettre une valeur correspondant à son occurence dans le panier
            $this->items[$serialized_product] = $quantity;
        }
    }

    /**
     * Méthode permettant de récupérer le nombre d'articles contenus dans le panier
     * @return int Le nombre d'articles dans le panier
     */
    public function get_number_of_items() : int {
        return count($this->items);
    }

    /**
     * Récupère le tableau contenant les produits dans le panier
     * @return array Le tableau contenant les produits
     */
    public function get_items() : array {
        return $this->items;
    }

    /**
     * Méthode permettant d'enregistrer tous les produits d'un panier donné dans la base de données
     * @param string $cart SESSION d'un panier
     * @param int $last_id_order L'ID de la dernière commande enregistrée (donc le numéro de commande auxquels les produits du panier sont liés)
     */
    public function save_products_in_DB(string $cart, int $last_id_order) : void {
        $database_link = new DatabaseLink();

        foreach (unserialize($cart)->get_items() as $item => $quantity) {
           $database_link->make_query("INSERT INTO `products_orders` (`id_product`, `id_order`, `quantity`) VALUES (?, ?, ?)", [unserialize($item)->get_id_product(), $last_id_order, $quantity]);
        }
    }

    /**
     * Méthode permettant de calculer le prix total d'un panier
     * @return float Le prix total des produits, arrondi au dixième
     */
    public function get_total_cost_of_items() : float {
        // On déclare la variable qui contiendra la somme totale
        $total = 0;

        // On parcourt tous les articles ainsi que leur prix
        foreach ($this->items as $item => $quantity) {
                $total += unserialize($item)->get_discounted_price() * $quantity;
        }

        return round($total, 2);
    }

    /**
     * Méthode permettant d'obtenir le coût de la livraison, si elle est inférieure à 29 euros, c'est payant, sinon c'est gratuit
     * @return float Le coût de livraison
     */
    public function get_delivery_fees() : float {
        if($this->get_total_cost_of_items() < 29) {
            return round($this->get_total_cost_of_items() * (Cart::SHIPPING_PERCENTAGE/100), 2);
        } else {
            return 0;
        }
    }

    /**
     * Méthode permettant de calculer la TVA.
     * Il faut inclure l'ensemble des articles, ainsi que la livraison selon la loi (aux mêmes taux).
     * @return float TVA applicable sur une commande.
     */
    public function get_vat() : float {
        return round($this->get_total_cost_of_items() * (Cart::VAT_PERCENTAGE/100), 2) + (round($this->get_delivery_fees() * (Cart::VAT_PERCENTAGE/100), 2));
    }

    /**
     * Méthode permettant d'avoir le total d'une commande.
     * Ce qui comprend le total des articles, les frais de livraison et la TVA sur les deux produits.
     * @return float Total d'une commande.
     */
    public function get_final_amount() : float {
        $amount = 0;

        $amount += $this->get_total_cost_of_items();
        $amount += $this->get_delivery_fees();
        $amount += $this->get_vat();

        return $amount;
    }

    /**
     * Méthode qui vérifie s'il y a assez de stock pour les produits souhaités
     * @return bool Vrai : le panier peut être confirmé car il y a assez de stock, faux : un article manque.
     */
    public function enough_supply() : bool {
        foreach ($this->items as $item => $quantity) {
            if(unserialize($item)->get_number_in_inventory() <= 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Méthode pour ajouter un panier au chariot
     * @param Basket $basket Panier composé
     * @return int Nombre de lignes insérées dans le chariot (normalement une)
     */
    public function add_basket(Basket $basket) : int {
        return array_push($this->items, $basket);
    }
}