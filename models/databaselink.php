<?php

/**
 * Classe olddatabaselink
 * Permet de faire la liaison avec la base de données et notamment en faisant des requêtes simples ou préparées
 */
class DatabaseLink {
    /* Attributs */
    private const HOST = "localhost";
    private const DB_NAME = "projet_tutore_web";
    private const USERNAME = "root";
    private const PASSWORD = "root";
    private const OPTIONS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];
    private PDO $PDO;

    /* Méthodes */

    /**
     * Constructeur de olddatabaselink
     */
    public function __construct() {
        $this->PDO = new PDO("mysql:host=" . DatabaseLink::HOST . ";dbname=" . DatabaseLink::DB_NAME . ";charset=UTF8", DatabaseLink::USERNAME, DatabaseLink::PASSWORD, DatabaseLink::OPTIONS);
    }

    /**
     * Méthode pour faire des requêtes simples ou préparées.
     * Si un tableau en deuxième argument est passé, alors c'est une requête préparée, sinon une requête simple
     * @param string $query La requête SQL à exécuter
     * @param array|null $variables Les variables qui doivent être mises dans la requête si requête préparées
     * @return false|PDOStatement Faux si la requête ne s'est pas déroulée avec succès, sinon, renvoie un PDOStatement
     */
    public function make_query(string $query, array $variables = null) {
        if(is_null($variables)) {
            $request = $this->PDO->query($query);
            $request->execute();
        } else {
            $request = $this->PDO->prepare($query);
            $request->execute($variables);
        }

        return $request;
    }

    /**
     * Méthode pour savoir le nombre de lignes retournées par un PDOStatement
     * @param PDOStatement $PDOStatement    Le PDOStatement d'une requête SQL
     * @return int  Représente le nombre de lignes retournées par la requête
     */
    public function number_of_returned_rows(PDOStatement $PDOStatement) : int {
        return $PDOStatement->rowCount();
    }

    /**
     * Méthode permettant de récupérer le dernier ID d'une instruction avec PDO
     * @see PDO::lastInsertId();
     * @return string Le dernier ID
     */
    public function get_last_id() : string {
        return $this->PDO->lastInsertId();
    }
}