<?php
class Cart {
    private array $items = array();
    private int $number_of_items;

    /**
     * Cart constructor.
     */
    public function __construct() {
        $this->number_of_items = count($this->items);
    }

    /**
     * Méthode pour ajouter des produits au panier
     * @param Product $product Le produit à ajouter
     * @return bool Vrai si le produit s'est bien ajouté, faux sinon
     */
    public function add_item(Product $product) : bool {
        // Ajout au tableau
        if(array_push($this->items, $product)) {
            $this->number_of_items = count($this->items);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Méthode permettant de renvoyer le nombre d'items contenus dans le panier
     * @return int Le nombre d'items dans le panier
     */
    public function get_number_of_items() : int {
        return $this->number_of_items;
    }

    /**
     * Récupère le tableau contenant les produits dans le panier
     * @return array Le tableau en question
     */
    public function get_items() : array {
        return $this->items;
    }

    /**
     * Méthode permettant de renvoyer le nombre d'items contenus dans le panier
     * @return int Le nombre d'items dans le panier
     */
    public function get_total_price() : float {
        // On déclare la variable qui contiendra la somme totale
        $total = 0;

        // On parcourt tous les articles
        foreach ($this->items as $item) {
            $total += $item->get_price();
        }

        return $total;
    }

}