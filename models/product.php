<?php
// Fichiers nécessaires
require_once "databaselink.php";

/**
 * Classe Product
 * Représente un article à vendre. Un produit est représenté par divers attributs situés ci-dessous.
 */
class Product {
    /** @var int  Identifiant unique d'un produit. Correspond à celui situé en BDD */
    private int $id_product;
    /** @var string Libellé d'un produit */
    private string $label;
    private string $type;
    private string $season;
    private string $classification;
    private string $description;
    private float $price;
    private int $number_in_inventory;
    private float $discount_rate;

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
     * @return string Type du produit (légumes, fruits, etc.)
     */
    public function get_type() : string {
        return $this->type;
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
     * @return int
     */
    public function get_number_in_inventory(): int {
        return $this->number_in_inventory;
    }

    /**
     * @return float
     */
    public function get_discount_rate(): float {
        return $this->discount_rate;
    }


    /**
     * Se charge d'hydrater l'objet.
     * @param int $product_id Identifiant unique d'un produit.
     * @return bool Vrai si la requête a fonctionné, faux sinon.
     */
    public function hydrate(int $product_id) : bool {
        $database_link = new DatabaseLink();
        $result_view = $database_link->make_query("SELECT `quantity`, `discount_rate` FROM `products.inventory` WHERE `id_product` = ?", [$product_id])->fetch();
        $result_table = $database_link->make_query("SELECT * FROM products WHERE `id_product` = ?", [$product_id])->fetch();

        // Si la requête n'aboutit pas, elle renvoie un false, donc ça veut dire qu'elle n'a pas marché, on renvoie alors false de notre côté également
        if($result_table == false) {
            return false;
        } else {
            $this->id_product = $result_table->id_product;
            $this->label = $result_table->label;
            $this->type = $result_table->type;
            $this->season = $result_table->season;
            $this->classification = $result_table->classification;
            $this->description = $result_table->description;
            $this->price = $result_table->price;
            $this->number_in_inventory = $result_view->quantity;
            $this->discount_rate = $result_view->discount_rate;
            return true;
        }
    }

    /**
     * Méthode pour ajouter un produit dans la base de données
     * @param string $label Libellé du produit
     * @param string $type Type du produit (Légumes, Fruits, etc.)
     * @param string $season Saison du produit
     * @param string $classification Classification du produit
     * @param string $description Description du produit
     * @param float $price Prix du produit
     * @return string L'ID du produit qui vient d'être entré
     */
    public function add(string $label, string $type, string $season, string $classification, string $description, float $price) : string {
        $database_link = new DatabaseLink();
        $database_link->make_query("INSERT INTO `products` (label, type, season, classification, description, price) VALUES(?, ?, ?, ?, ?, ?)", [$label, $type, $season, $classification, $description, $price]);

        $product_id = $database_link->get_last_id();
        // Par défaut, on dit que le stock est à 0, et la promotion à 0 également.
        $database_link->make_query("INSERT INTO `products.inventory` (`id_product`, `quantity`, `discount_rate`) VALUES ($product_id, 0, 0)");

        return $product_id;
    }

    /**
     * Méthode pour mettre à jour un produit dans la base de données
     * @param int $id_product ID du produit à mettre à jour
     * @param string $label Libellé du produit
     * @param string $type Type du produit (Légumes, Fruits, etc.)
     * @param string $season Saison du produit
     * @param string $classification Classification du produit
     * @param string $description Description du produit
     * @param float $price Prix du produit
     */
    public function update(int $id_product, string $label, string $type, string $season, string $classification, string $description, float $price) {
        $database_link = new DatabaseLink();
        $database_link->make_query("UPDATE `products` SET `label` = ?, `type` = ?, `season` = ?, `classification` = ?, `description` = ?, `price` = ? WHERE `id_product` = ?", [$label, $type, $season, $classification, $description, $price, $id_product]);
    }

    /**
     * Méthode pour mettre à jour l'inventaire d'un produit
     * @param int $id_product ID du produit à mettre à jour
     * @param int $quantity La quantité disponible
     * @param int $discount_rate Taux de promotion
     */
    public function update_inventory(int $id_product, int $quantity, int $discount_rate) {
        $database_link = new DatabaseLink();
        $database_link->make_query("UPDATE `products.inventory` SET `quantity` = ?, `discount_rate` = ? WHERE `id_product` = ?", [$quantity, $discount_rate, $id_product]);
    }
}