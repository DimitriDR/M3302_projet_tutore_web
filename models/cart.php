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
     */
    public function add_item(Product $product): void {
        $serialized_product = serialize($product);

        // On vérifie si l'article n'est pas déjà dans le panier (on vérifie sur les clés car le produit est stocké dans la clé)
        if (array_key_exists($serialized_product, $this->items)) {
            // Si c'est le cas, on va incrémenter la valeur du produit
            // Mais il faut d'abord récupérer la valeur correspondant à la bonne clé
            $this->items[$serialized_product] = $this->items[$serialized_product]+1;
        } else {
            // Si ce n'est pas le cas, on va le mettre dans un tableau associatif et mettre une valeur correspondant à son occurence dans le panier
            $this->items[$serialized_product] = 1;
        }
        // Dans tous les cas, on incrémente de 1
        $this->number_of_items += 1;
    }

    /**
     * Méthode permettant de renvoyer le nombre d'items contenus dans le panier
     * @return int Le nombre d'items dans le panier
     */
    public function get_number_of_items(): int {
        return $this->number_of_items;
    }

    /**
     * Récupère le tableau contenant les produits dans le panier
     * @return array Le tableau en question
     */
    public function get_items(): array {
        return $this->items;
    }

    /**
     * Méthode permettant de renvoyer le nombre d'items contenus dans le panier
     * @return float Le nombre d'items dans le panier
     */
    public function get_total_price(): float {
        // On déclare la variable qui contiendra la somme totale
        $total = 0;

        // On parcourt tous les articles
        foreach ($this->items as $item => $quantity) {
            $total += unserialize($item)->get_price() * $quantity;
        }

        return $total;
    }

}