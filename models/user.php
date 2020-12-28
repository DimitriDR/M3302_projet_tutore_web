<?php

require_once "databaselink.php";

/**
 * Class User
 * Représente un utilisateur
 */
class User {
    private int $id_user;
    private string $last_name;
    private string $first_name;
    private string $street_name;
    private int $zip_code;
    private string $district;
    private string $city;
    private int $mobile_number;
    private string $email_address;

    public function register(string $last_name, string $first_name, string $password, string $street_name, int $zip_code, string $district, string $city, int $mobile_number, string $email_address) : bool {
        // Connexion à la base de données
        $database_link = new DatabaseLink();

        // Création d'un mot de passe chiffré avec l'algorithme ARGON2ID
        $secure_password = password_hash($password, PASSWORD_ARGON2ID);

        // Une requête préparée car on doit insérer des informations données par l'utilisateur
        $register = $database_link->make_query("INSERT INTO `users` (last_name, first_name, password, street_name, zip_code, district, city, mobile_number, email_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $last_name,
            $first_name,
            $secure_password,
            $street_name,
            $zip_code,
            $district,
            $city,
            $mobile_number,
            $email_address
        ]);

        // Si on n'a pas un retour égal à false, la requête s'est bien passée
        if ($register) {
            return true;
        } else {
            return false;
        }
    }
}