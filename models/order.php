<?php
require_once dirname(__DIR__) . "/models/product.php";

/**
 * Classe Order représentant une commande
 */
class Order {
    /** @var int Représente l'identifiant unique d'une commande */
    private int $id_order;
    /** @var int Représente l'identifiant unique de l'utilisateur qui a passé commande */
    private int $id_user;
    /** @var string Représente la date de création */
    private string $date;
    /** @var int Représente le statut d'une commande
     * -1 : annulée
     * 0 : non confirmé par le producteur
     * 1 : confirmé par le producteur
     * 2 : en cours de livraison
     */
    private int $status;
    /** @var float Total de la commande */
    private float $amount;

    /**
     * @return int L'identifiant unique de la commande
     */
    public function get_id_order() : int {
        return $this->id_order;
    }

    /**
     * @return int L'identifiant unique de l'utilisateur
     */
    public function get_id_user() : int {
        return $this->id_user;
    }

    /**
     * @return string La date de création de la commande
     */
    public function get_raw_date() : string {
        return $this->date;
    }

    /**
     * Méthode qui retourne une date sous un format plus lisible
     * @return string La date
     */
    public function get_date() : string {
        return date("d/m/Y à H:i", strtotime($this->date));
    }

    /**
     * @return int Le statut de la commande
     * -1 : annulée
     * 0 : non confirmé par le producteur
     * 1 : confirmé par le producteur
     * 2 : en cours de livraison
     * 3 : livré
     */
    public function get_raw_status() : int {
        return $this->status;
    }

    /**
     * @return float
     */
    public function get_amount() : float {
        return $this->amount;
    }

    /**
     * Fonction pour traduire les status de code en texte
     * @return string Le texte littéral du status
     */
    function get_status() : string {
        switch ($this->status) {
            case -1:
                return "Annulée";
            case 0 :
                return "Non confirmée";
            case 1:
                return "Confirmée";
            case 2:
                return "En cours de livraison";
            case 3:
                return "Livrée";
            default:
                return "Erreur";
        }
    }

    public function hydrate(int $id_order) : bool {
        $database_link = new DatabaseLink();
        $results = $database_link->make_query("SELECT * FROM orders WHERE id_order = ?", [$id_order])->fetch();
        // Si la requête n'aboutit pas, elle renvoie un false, donc ça veut dire qu'elle n'a pas marché, on renvoie alors false de notre côté également
        if($results == false) {
            return false;
        } else {
            $this->id_order = $results->id_order;
            $this->id_user = $results->id_user;
            $this->date = $results->date;
            $this->status = $results->status;
            $this->amount = $results->amount;
            return true;
        }
    }

    /**
     * Méthode pour enregister une commande (dans la table Orders)
     * @param string $id_user L'ID de l'utilisateur qui commande
     * @param float $amount Le total de la commande
     * @return int L'ID de la commande qui vient d'être inséré
     */
    public function register(string $id_user, float $amount) : int {
        $database_link = new DatabaseLink();

        $database_link->make_query("INSERT INTO `orders` (id_user, date, status, amount) VALUES (?, ?, ?, ?)", [$id_user, date("Y-m-d H:i:s"), 0, $amount]);

        return $database_link->get_last_id();
    }

    /**
     * Méthode permettant de vérifier qu'il est possible de faire une commande.
     * C'est-à-dire si aucune commande n'est déjà en attente pour l'utilisateur courant.
     * @param int $user_id
     * @return bool
     */
    public function is_possible(int $user_id) : bool {
        $database_link = new DatabaseLink();
        $query = $database_link->make_query("SELECT `id_order` FROM orders WHERE id_user = ? AND status = 0", [$user_id]);
        $fetch = $query->fetchAll();

        // S'il y a déjà une commande encore non confirmée, on refuse d'en enregistrer une nouvelle
        if(count($fetch) >= 1) {
            return false;
        }

        return true;
    }

    /**
     * Méthode permettant d'avoir une couleur en fonction du statut de la commande
     * @return string La couleur
     */
    public function status_color() : string {
        switch ($this->status) {
            case -1:
                return "danger";
            case 0:
                return "secondary";
            case 1:
                return "primary";
            case 2:
                return "info";
            case 3:
                return "success";
            default:
                return "light";
        }
    }

    public function list_of_products() : array {
        $database_link = new DatabaseLink();
        $query = $database_link->make_query("SELECT id_product FROM products_orders WHERE id_order = ?", [$this->id_order]);
        return $query->fetchAll();
    }

    /**
     * Méthode qui se charge de changer le status d'une commande selon le statut reçu en paramètre.
     * @param int $status Le nouveau statut
     */
    public function change_status(int $status) : void {
        $database_link = new DatabaseLink();
        $database_link->make_query("UPDATE orders SET status = ? WHERE id_order = ?", [$status ,$this->id_order]);
    }

    public function remove_inventory() {
        $database_link = new DatabaseLink();
        $query = $database_link->make_query("SELECT id_product, quantity FROM products_orders WHERE id_order = ?", [$this->id_order]);
        $fetch = $query->fetchAll();

        foreach ($fetch as $row) {
            $product = new Product();
            $product->hydrate($row->id_product);
            $product->remove_quantity_from_inventory($row->quantity);
        }
    }
}