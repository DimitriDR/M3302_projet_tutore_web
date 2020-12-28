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

    public function check_credentials(string $email, string $password) : bool {
        $databaselink = new DatabaseLink();
        $get_user_password = $databaselink->make_query("SELECT `password` FROM users WHERE `email_address` = ?", [$email]);

        if($databaselink->number_of_returned_rows($get_user_password)) {
            if(password_verify($password, $get_user_password->fetchColumn())) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function login(string $email) : void {
        $databaselink = new DatabaseLink();
        $get_user_information = $databaselink->make_query("SELECT * FROM users WHERE `email_address` = ?", [$email]);

        $user_information = $get_user_information->fetch();

        if($databaselink->number_of_returned_rows($get_user_information)) {
            $this->id_user = $user_information->id_user;
            $this->last_name = $user_information->last_name;
            $this->first_name = $user_information->first_name;
            $this->street_name = $user_information->street_name;
            $this->zip_code = $user_information->zip_code;
            $this->district = $user_information->district;
            $this->city = $user_information->city;
            $this->mobile_number = $user_information->mobile_number;
            $this->mobile_number = $user_information->mobile_number;
        }
    }

    /**
     * Méthode pour générer un token anti-CSRF
     * @return string Le token
     */
    public function create_token() : string {
        try {
            return bin2hex(random_bytes(32));
        } catch (Exception $e) {
            die("Une erreur s'est produite lors de la génération du token :<br />".$e->getMessage());
        }
    }
}