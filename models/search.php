<?php
require_once "databaselink.php";

class Search {
    /** @var string Les termes de la recherche */
    private string $query;
    /** @var array Contient les résultats de la recherche */
    private array $results;

    /**
     * Constructeur de l'objet Search.
     * @param string $query Les termes recherchés.
     */
    public function __construct(string $query) {
        $this->query = $query;
    }

    /**
     * @return string Les termes de la recherche.
     */
    public function get_query() : string {
        return $this->query;
    }

    /**
     * Méthode permettant de faire la recherche dans la base de données.
     * @return array Le résultat de la recherche sous la forme d'un PDOStatement ou false si la requête a échoué.
     */
    public function request_db() : array {
        $database = new DatabaseLink();
        $results = $database->make_query("SELECT `id_product` FROM products WHERE label LIKE ?", ["%$this->query%"]);
        return $this->results = $results->fetchAll();
    }

    /**
     * Méthode permettant d'afficher le nombre de produits trouvés
     */
    public function get_number_of_results() : string {
        $number = count($this->results);

        if($number <= 1) {
            return $number . " produit";
        } else {
            return $number . " produits";
        }
    }

}