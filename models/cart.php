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
     * Méthode permettant de renvoyer le nombre d'items contenus dans le panier
     * @return int Le nombre d'items dans le panier
     */
    public function get_number_of_items() : int {
        return $this->number_of_items;
    }

}