<?php
require_once "databaselink.php";

class Product {
    private int $id_product;
    private string $label;
    private string $season;
    private string $classification;
    private string $description;
    private float $price;

    /**
     * Getter permettant de récupérer l'ID
     * @return int  ID
     */
    public function get_id_product() : int {
        return $this->id_product;
    }

    /**
     * Getter permettant de récupérer le nom
     * @return string Nom
     */
    public function get_label(): string {
        return $this->label;
    }

    /**
     * Getter permettant de récupérer la saison
     * @return string Saison
     */
    public function get_season(): string {
        return $this->season;
    }

    /**
     * Getter permettant de récupérer la classification
     * @return string Classfication
     */
    public function get_classification(): string {
        return $this->classification;
    }

    /**
     * Getter permettant de récupérer la description
     * @return string Description
     */
    public function get_description(): string {
        return $this->description;
    }

    /**
     * Getter permettant de récupérer le prix
     * @return float Prix
     */
    public function get_price(): float {
        return $this->price;
    }

    /**
     * Se charge d'hydrater l'objet.
     * @param int $product_id Identifiant unique d'un produit.
     */
    public function hydrate(int $product_id) {
        $database_link = new DatabaseLink();
        $results = $database_link->make_query("SELECT * FROM products WHERE id_product = ?", [$product_id])->fetch();

        $this->id_product = $results->id_product;
        $this->label = $results->label;
        $this->season = $results->season;
        $this->classification = $results->classification;
        $this->description = $results->description;
        $this->price = $results->price;
    }

    public function add(string $label, string $season, string $classification, string $description, float $price) {
        $database_link = new DatabaseLink();
        $database_link->make_query("INSERT INTO `products` (label, season, classification, description, price) VALUES(?, ?, ?, ?, ?)", [$label, $season, $classification, $description, $price]);
    }
}