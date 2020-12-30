<?php

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
    public function get_date() : string {
        return $this->date;
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
     * Fonction pour traduire les status de code en texte
     * @return string Le texte littéral du status
     */
    function get_status() : string {
        switch ($this->status) {
            case -1:
                return "<span class='text-danger'>Annulé par l'utilisateur</span>";
            case 0 :
                return "<span class='text-warning'>Non confirmé</span>";
            case 1:
                return "<span class='text-info'>Confirmé</span>";
            case 2:
                return "<span class='text-success'>En cours de livraison</span>";
            case 3:
                return "<span class='text-success'>Livré</span>";
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
            return true;
        }
    }

    /**
     * Méthode pour enregister une commande (dans la table Orders)
     * @param string $id_user L'ID de l'utilisateur qui commande
     * @return int L'ID de la commande qui vient d'être inséré
     */
    public function register(string $id_user) : int {
        $database_link = new DatabaseLink();

        $database_link->make_query("INSERT INTO `orders` (id_user, date, status) VALUES (?, ?, ?)", [$id_user, date("Y-m-d H:i:s"), 0]);

        return $database_link->get_last_id();
    }
}