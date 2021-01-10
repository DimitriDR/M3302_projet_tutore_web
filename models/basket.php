<?php
require_once dirname(__DIR__) . "/models/databaselink.php";

/**
 * Classe Basket modélisant un panier composé par le producteur
 */
class Basket {
    /* Attributs */

    /** @var int Identifiant unique du panier */
    private int $id_basket;

    /** @var float Prix du panier */
    private float $price;

    /** @var array Liste des produits présents dans le panier */
    private array $list_of_products;

    /* Méthodes */
    /**
     * @return int Identifiant unique du panier
     */
    public function get_id_basket(): int {
        return $this->id_basket;
    }

    /**
     * @return float
     */
    public function get_price(): float {
        return $this->price;
    }

    /**
     * @return array
     */
    public function get_list_of_products(): array {
        return $this->list_of_products;
    }

    /**
     * Méthode permettant d'instancier
     * @param float $price
     * @param array $products
     */
    public function create(float $price, array $products): void {
        $database_link = new DatabaseLink();
        $database_link->make_query("INSERT INTO `baskets` (price) VALUES (?)", [$price]);

        $id_basket = $database_link->get_last_id();

        foreach ($products as $one_product) {
            $query = $database_link->make_query("SELECT id_product FROM products WHERE label = ?", [$one_product]);
            $product_id = $query->fetchColumn();
            $database_link->make_query("INSERT INTO `products_basket` (id_product, id_basket, quantity) VALUES (?, ?, 1)", [$product_id, $id_basket]);
        }
    }
}