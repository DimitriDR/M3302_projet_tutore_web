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
    private string $unit;
    private int $number_in_inventory;
    private float $discount_rate;
    private string $file;
    /** @var float Le nouveau prix si une promotion est applicable */
    private float $discounted_price;

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
     * @return string
     */
    public function get_unit(): string {
        return $this->unit;
    }

    /**
     * @return string
     */
    public function get_file(): string {
        return $this->file;
    }

    /**
     * @return float
     */
    public function get_discounted_price(): float {
        return $this->discounted_price;
    }

    /**
     * Se charge d'hydrater l'objet, c'est-à-dire que l'on prend les données de la base de données et qu'on les met dans les attributs de l'objet
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
            $this->unit = $result_table->unit;
            $this->number_in_inventory = $result_view->quantity;
            $this->discount_rate = $result_view->discount_rate;
            $this->file = $result_table->file_name;
            $this->discounted_price = $this->price * (1-($this->discount_rate/100));
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
     * @param array $file
     * @param bool $is_update Mettre "true" si c'est une mise à jour d'un produit, valeur par défaut à "false"
     * @param int|null $id_product ID du produit à mettre à jour si mise à jour
     * @return int L'ID du produit qui vient d'être entré
     */
    public function change(string $label, string $type, string $season, string $classification, string $description, float $price, string $unit, array $file = null, bool $is_update = false, int $id_product = null) : int {
        $database_link = new DatabaseLink();

        // Le nom du fichier à insérer dans la base de données
        $file_name = strtolower($label) . "." . pathinfo($file["name"], PATHINFO_EXTENSION);

        // Si c'est une simple mise à jour ...
        if($is_update === true) {
            $database_link->make_query("UPDATE `products` SET `label` = ?, `type` = ?, `season` = ?, `classification` = ?, `description` = ?, `price` = ?, `unit` = ?, `file_name` = ? WHERE `id_product` = ?", [$label, $type, $season, $classification, $description, $price, $unit, $file_name, $id_product]);
        } else {
            // Si on veut ajouter un nouveau produit, il faut faire plus de choses
            $database_link->make_query("INSERT INTO `products` (`label`, `type`, `classification`, `description`, `price`, `season`, `unit`, `file_name`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", [$label, $type, $classification, $description, $price, $season, $unit, $file_name]);

            // On récupère l'ID du produit qui vient d'être saisi
            $just_entered_product_id = $database_link->get_last_id();

            // Par défaut, on dit que le stock est à 0, et la promotion à 0 également.
            $database_link->make_query("INSERT INTO `products.inventory` (`id_product`, `quantity`, `discount_rate`) VALUES (?, 0, 0)", [$just_entered_product_id]);

            // On convertit la valeur en entier car tous nos clés primaires sont des entiers
            return intval($just_entered_product_id);
         }

         return 0;
    }

    /**
     * Méthode permettant de mettre à jour un produit
     * @param int $id_product
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
        if(is_null($image_file)) {
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
            $database_link->make_query("UPDATE `products` SET label = ?, type = ?, classification = ?, description = ?, price = ?, season = ?, unit = ?, file_name = ? WHERE id_product = ?", [
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

            // Il faut maintenant mettre à jour dans le dossier
            unlink(dirname(__DIR__) . "views/assets/images/products/$this->file");

            // On peut mettre l'image sur le serveur
            move_uploaded_file($image_file["tmp_name"], dirname(__DIR__) . "/views/assets/images/products/$label.$image_file_extension");
        }
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

    /**
     * @param array $file
     * @param string $file_label
     * @return bool
     * @deprecated
     */
    private function upload_image_to_server(array $file, string $file_label) : bool {
        // Le nom final du fichier
        // Au format [label] (tout en minuscule).[extension]
        $file_name = strtolower($file_label) . pathinfo($file["name"], PATHINFO_EXTENSION);

        return move_uploaded_file($file["name"], dirname(__DIR__) . "/views/assets/images/products/$file_name");
    }

    /**
     * Méthode permettant d'obtenir la quantité d'un produit.
     * @param int $id_order Le numéro de la commande qui contient le produit dont on souhaite la quantité.
     * @return int La quantité du produit dans la commande donnée.
     */
    public function get_quantity_in_order(int $id_order) : int {
        $database_link = new DatabaseLink();
        $query = $database_link->make_query("SELECT quantity FROM products_orders WHERE id_order = ? AND id_product = ?", [$id_order, $this->id_product]);
        return $query->fetchColumn();
    }

    public function get_quantity_in_inventory() : int {
        $database_link = new DatabaseLink();
        $query = $database_link->make_query("SELECT quantity FROM `products.inventory` WHERE id_product = ?", [$this->id_product]);
        return $query->fetchColumn();
    }

    /**
     * Méthode permettant de retirer du stock selon la quantité qui a été prise lors d'une commande.
     * @param int $quantity_in_order Quantité du produit actuel qui a été retirée d'une commande.
     */
    public function remove_quantity_from_inventory(int $quantity_in_order) {
        $database_link = new DatabaseLink();
        // On calcule la quantité restante si on enlève la quantité de la commande
        $remaining_quantity = $this->get_quantity_in_inventory() - $quantity_in_order;

        $database_link->make_query("UPDATE `products.inventory` SET quantity = ? WHERE id_product = ?", [$remaining_quantity, $this->id_product]);
    }
}