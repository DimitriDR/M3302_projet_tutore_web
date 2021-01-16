<?php
/**
 * @version 1.0 Reviewed and compliant file
 */
require_once dirname(__DIR__) . "/models/databaselink.php";

/**
 * Classe Product
 * Représente un article à vendre. Un produit est représenté par divers attributs situés ci-dessous.
 */
class Product
{
    /* Attributs */

    /** @var int  Identifiant unique d'un produit. Correspond à celui situé en BDD */
    private int $id_product;

    /** @var string Libellé d'un produit */
    private string $label;

    /** @var string Type du produit (légume, fruit, etc.) */
    private string $type;

    /** @var string Saison pendant laquelle le produit est vendu */
    private string $season;

    /** @var string Classification du produit */
    private string $classification;

    /** @var string Description complète du produit */
    private string $description;

    /** @var float Prix brut (c'est-à-dire le prix non soldé) HT du produit */
    private float $price;

    /** @var string Unité du produit (la pièce/le kg) */
    private string $unit;

    /** @var int  Quantité présente en stock */
    private int $number_in_inventory;

    /** @var float Taux de promotion applicable */
    private float $discount_rate;

    /** @var string Nom de l'image lié à notre produit */
    private string $file;

    /** @var float Le nouveau prix si une promotion est applicable */
    private float $discounted_price;

    /* Méthodes */

    /**
     * Getter permettant de récupérer l'identifiant unique du produit.
     * @return int Identifiant unique du produit.
     */
    public function get_id_product() : int {
        return $this->id_product;
    }

    /**
     * Getter permettant de récupérer le nom du produit.
     * @return string Nom du produit.
     */
    public function get_label() : string {
        return $this->label;
    }

    /**
     * Getter permettant de récupérer la saison du produit.
     * @return string Saison du produit.
     */
    public function get_season() : string {
        return $this->season;
    }

    /**
     * Getter permettant de récupérer la classification du produit.
     * @return string Classfication du produit.
     */
    public function get_classification() : string {
        return $this->classification;
    }

    /**
     * Getter permettant de récupérer le type du produit.
     * @return string Type du produit (légumes, fruits, etc.).
     */
    public function get_type() : string {
        return $this->type;
    }

    /**
     * Getter permettant de récupérer la description du produit.
     * @return string Description du produit.
     */
    public function get_description() : string {
        return $this->description;
    }

    /**
     * Getter permettant de récupérer le prix brut du produit.
     * @return float Prix brut du produit.
     */
    public function get_price() : float {
        return $this->price;
    }

    /**
     * Getter permettant de récupérer la quantité du produit en stock.
     * @return int Quantité du produit.
     */
    public function get_number_in_inventory() : int {
        return $this->number_in_inventory;
    }

    /**
     * Getter permettant de récupérer le taux de promotion du produit.
     * @return float Taux de promotion (sous la forme 10, 20 (%)).
     */
    public function get_discount_rate() : float {
        return $this->discount_rate;
    }

    /**
     * Getter pour récupérer l'unité du produit.
     * @return string Unité du produit (donc soit "/ kg", "la pièce").
     */
    public function get_unit() : string {
        return $this->unit;
    }

    /**
     * Getter pour récupérer le nom de l'image lié au produit.
     * @return string Nom de l'image (par exemple Carotte.jpg pour les carottes).
     */
    public function get_file() : string {
        return $this->file;
    }

    /**
     * getter pour avoir le prix où la promotion est appliqué.
     * @return float Prix après déduction de la promotion.
     */
    public function get_discounted_price() : float {
        return $this->discounted_price;
    }

    /**
     * Se charge d'hydrater l'objet, c'est-à-dire que l'on prend les données de la base de données et qu'on les met dans les attributs de l'objet.
     * @param int $product_id Identifiant unique d'un produit.
     * @return bool Vrai si la requête a fonctionné, faux sinon.
     */
    public function hydrate(int $product_id) : bool {
        $database_link = new DatabaseLink();

        $result_table_products = $database_link->make_query("SELECT * FROM `products` WHERE `id_product` = ?", [$product_id])->fetch();
        $result_table_products_inventory = $database_link->make_query("SELECT `quantity`, `discount_rate` FROM `products.inventory` WHERE `id_product` = ?", [$product_id])->fetch();

        // Si la requête n'aboutit pas, elle renvoie false, ça veut dire qu'elle n'a pas marché, par conséquent on renvoie alors false de notre côté également
        if ($result_table_products == false) {
            return false;
        } else {
            $this->id_product = $result_table_products->id_product;
            $this->label = $result_table_products->label;
            $this->type = $result_table_products->type;
            $this->season = $result_table_products->season;
            $this->classification = $result_table_products->classification;
            $this->description = $result_table_products->description;
            $this->price = $result_table_products->price;
            $this->unit = $result_table_products->unit;
            $this->number_in_inventory = $result_table_products_inventory->quantity;
            $this->discount_rate = $result_table_products_inventory->discount_rate;
            $this->file = $result_table_products->file_name;
            $this->discounted_price = $this->price * (1 - ($this->discount_rate / 100));
            return true;
        }
    }

    /**
     * Méthode permettant soit d'ajouter, soit de mettre à jour un produit.
     * @param string $label Libellé du produit
     * @param string $type Type du produit (Légumes, Fruits, etc.)
     * @param string $season Saison du produit
     * @param string $classification Classification du produit
     * @param string $description Description du produit
     * @param float $price Prix du produit
     * @param string $unit L'unité du produit
     * @param array $file Le fichier qui vient d'être uploadé (typiquement le $_FILES[...])
     * @return int Identifiant unique du produit qui vient d'être créé
     */
    public function add(string $label, string $type, string $season, string $classification, string $description, float $price, string $unit, array $file) : int {
        $database_link = new DatabaseLink();

        // On définit le nom du fichier à insérer dans la base de données
        $file_name = strtolower($label) . "." . pathinfo($file["name"], PATHINFO_EXTENSION);

        // On insère le produit dans la table `products`
        $database_link->make_query("INSERT INTO `products` (`label`, `type`, `classification`, `description`, `price`, `season`, `unit`, `file_name`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", [$label, $type, $classification, $description, $price, $season, $unit, $file_name]);

        // On récupère l'ID du produit qui vient d'être saisi
        $just_entered_product_id = $database_link->get_last_id();

        // Par défaut, on dit que le stock est à 0, et la promotion à 0 également.
        $database_link->make_query("INSERT INTO `products.inventory` (`id_product`, `quantity`, `discount_rate`) VALUES (?, 0, 0)", [$just_entered_product_id]);

        // Enfin, on met l'image sur le serveur
        $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["image"]["tmp_name"], dirname(__DIR__) . "/views/assets/images/products/" . strtolower($label) . "." . $file_extension);

        return $just_entered_product_id;
    }

    /**
     * Méthode permettant de mettre à jour un produit
     * @param string $label
     * @param string $type
     * @param string $classification
     * @param string $desription
     * @param float $price
     * @param string $season
     * @param string $unit
     * @param array|null $image_file
     * @param string|null $image_file_extension
     */
    public function update_product(string $label, string $type, string $classification, string $desription, float $price, string $season, string $unit, array $image_file = null, string $image_file_extension = null) : void {
        $database_link = new DatabaseLink();

        // La requête va dépendre de s'il y a une nouvelle image à mettre
        // S'il n'y a pas de nouvelle image, on ne touche à pas à l'image située sur le serveur
        if (is_null($image_file)) {
            $database_link->make_query("UPDATE `products` SET label = ?, type = ?, classification = ?, description = ?, price = ?, season = ?, unit = ? WHERE id_product = ?", [
                $label,
                $type,
                $classification,
                $desription,
                $price,
                $season,
                $unit,
                $this->id_product
            ]);
        } else {
            // On effectue d'abord la requête
            $database_link->make_query("UPDATE `products` SET `label` = ?, `type` = ?, `classification` = ?, `description` = ?, `price` = ?, `season` = ?, `unit` = ?, `file_name` = ? WHERE `id_product` = ?", [
                $label,
                $type,
                $classification,
                $desription,
                $price,
                $season,
                $unit,
                $label . "." . $image_file_extension,
                $this->id_product
            ]);

            // Il faut maintenant supprimer l'image actuelle située sur le serveur
            unlink(dirname(__DIR__) . "views/assets/images/products/$this->file");

            // On peut mettre maintenant la nouvelle image sur le serveur
            move_uploaded_file($image_file["tmp_name"], dirname(__DIR__) . "/views/assets/images/products/$label.$image_file_extension");
        }
    }

    /**
     * Méthode pour mettre à jour l'inventaire d'un produit
     * @param int $id_product ID du produit à mettre à jour
     * @param int $quantity La quantité disponible à présent
     * @param int $discount_rate Taux de promotion
     */
    public function update_inventory(int $id_product, int $quantity, int $discount_rate) : void {
        $database_link = new DatabaseLink();
        $database_link->make_query("UPDATE `products.inventory` SET `quantity` = ?, `discount_rate` = ? WHERE `id_product` = ?", [$quantity, $discount_rate, $id_product]);
    }

    /**
     * Méthode permettant d'obtenir la quantité d'un produit dans une commande
     * @param int $id_order Le numéro de la commande qui contient le produit dont on souhaite la quantité.
     * @return int La quantité du produit dans la commande donnée.
     */
    public function get_quantity_from_order(int $id_order) : int {
        $database_link = new DatabaseLink();
        $query = $database_link->make_query("SELECT `quantity` FROM `products_orders` WHERE `id_order` = ? AND `id_product` = ?", [$id_order, $this->id_product]);
        return $query->fetchColumn();
    }

    /**
     * Méthode permettant de retirer du stock selon la quantité qui a été prise lors d'une commande.
     * @param int $quantity_in_order Quantité du produit actuel qui a été retirée d'une commande.
     */
    public function remove_quantity_from_inventory(int $quantity_in_order) {
        $database_link = new DatabaseLink();

        // On calcule la quantité restante si on enlève la quantité de la commande
        $remaining_quantity = $this->number_in_inventory - $quantity_in_order;

        $database_link->make_query("UPDATE `products.inventory` SET `quantity` = ? WHERE `id_product` = ?", [$remaining_quantity, $this->id_product]);
    }
}