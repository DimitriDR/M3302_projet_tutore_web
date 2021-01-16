<?php
/**
 * @version 1.0 Reviewed and compliant file
 */

require_once dirname(__DIR__) . "/models/databaselink.php";

/**
 * Classe Search qui permet d'effectuer des recherches de produit
 */
class Search {
    /* Attributs */
    /** @var string Les termes de la recherche */
    private string $query;

    /** @var array Contient les résultats de la recherche */
    private array $results;

    /* Méthodes */

    /**
     * Constructeur de l'objet Search qui se charge de mettre les termes de la recherche dans l'attribut.
     * @param string $query Les termes recherchés.
     */
    public function __construct(string $query) {
        $this->query = $query;
    }

    /**
     * Méthode pour récupérer les résultats de la recherche.
     * @return array Les résultats de la recherche contenus dans un tableau sont des objets Product.
     */
    public function get_results() : array {
        return $this->results;
    }

    /**
     * Méthode permettant de lancer la recherche dans la base de données.
     * @return void Le résultat de la recherche sous la forme d'un PDOStatement ou false si la requête a échoué.
     */
    public function request_db() : void {
        $database = new DatabaseLink();
        $results = $database->make_query("SELECT `id_product` FROM `products` NATURAL JOIN `products.inventory` WHERE quantity > 0 AND label LIKE ?", ["%$this->query%"]);
        $this->results = $results->fetchAll();
    }

    /**
     * Méthode permettant d'afficher le nombre de produits trouvés
     * @return string Les produits trouvés
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