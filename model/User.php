<?php
require_once "DatabaseLink.php";

class User {
    /* Attributs */
    /** @var int Identifiant unique de l'utilisateur */
    private int $id_user;
    /** @var string Nom de famille */
    private string $last_name;
    /** @var string Prénom de l'utilisateur */
    private string $first_name;
    /** @var string Adresse de l'utilisateur */
    private string $street_name;
    /** @var int Code postal de la ville */
    private int $zip_code;
    /** @var string Quartier / Arrondissement dans lequel habite l'utilisateur */
    private string $district;
    /** @var string Représente la ville dans laquelle l'utilisateur habite */
    private string $city;
    /** @var int Représente le numéro de téléphone de l'utilisateur */
    private int $mobile_number;
    /** @var string Représente l'adresse e-mail de l'utilisateur */
    private string $email_address;

    /* Méthodes */

    /**
     * Méthode pour inscrire un utilisateur dans la base de données
     * @param string $last_name Nom de l'utilisateur
     * @param string $first_name Prénom de l'utilisateur
     * @param string $password Mot de passe choisi par l'utilisateur
     * @param string $street_name Nom de la rue dans laquelle habite l'utilisateur
     * @param int $zip_code Code postal de la ville
     * @param string $district Quartier / Arrondissement dans lequel l'utilisateur vit
     * @param string $city Nom de la ville
     * @param int $mobile_number Numéro de téléphone portable
     * @param string $email_address Son adresse e-mail
     * @return bool Vrai si l'inscription s'est bien enregistrée dans la base de données, faux sinon
     */
    public function register(string $last_name, string $first_name, string $password, string $street_name, int $zip_code, string $district, string $city, int $mobile_number, string $email_address): bool {
        // Connexion à la base de données
        $database_link = new DatabaseLink();

        // Création d'un mot de passe chiffré
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

    /**
     * Méthode pour vérifier les identifiants
     * @param string $email_address L'adresse e-mail de l'utilisateur
     * @param string $password Le mot de passe de l'utilisateur
     * @return bool Vrai si les identifiant sont bons, faux sinon
     */
    public function check_login(string $email_address, string $password): bool {
        // Connexion à la base de données
        $database_link = new DatabaseLink();

        $password_verify_result = null;
        $user_fetch = null;

        /* On récupère toutes les informations de l'utilisateur pour :
            - dans un premier temps, vérifier le mot de passe
            - hydrater l'objet
        */
        $user_information = $database_link->make_query("SELECT * FROM `users` WHERE `email_address` = ?", [$email_address]);

        if ($database_link->number_of_returned_rows($user_information)) {
            $user_fetch = $user_information->fetch();
            $password_in_database = $user_fetch->password;
            $password_verify_result = password_verify($password, $password_in_database);
        }

        if ($password_verify_result) {
            $this->id_user = $user_fetch->id_user;
            $this->last_name = $user_fetch->last_name;
            $this->first_name = $user_fetch->first_name;
            $this->street_name = $user_fetch->street_name;
            $this->zip_code = $user_fetch->zip_code;
            $this->district = $user_fetch->district;
            $this->city = $user_fetch->city;
            $this->mobile_number = $user_fetch->mobile_number;
            $this->email_address = $user_fetch->email_address;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Méthode pour connecter un utilisateur
     */
    public function login() {
        $_SESSION["user"] = new ArrayObject(array(
            "id_user" => $this->id_user,
            "last_name" => $this->last_name,
            "first_name" => $this->first_name,
            "street_name" => $this->street_name,
            "zip_code" => $this->zip_code,
            "district" => $this->district,
            "city" => $this->city,
            "mobile_number" => $this->mobile_number,
            "email_address" => $this->email_address
        ), ArrayObject::ARRAY_AS_PROPS);

        // Génération du token anti-CSRF
        try {
            $_SESSION["user_token"] = bin2hex(random_bytes(32));
        } catch (Exception) {
            die("Une erreur s'est produite lors de la génération du token");
        }
    }

    /**
     * Méthode permettant de vérifier le mot de passe d'un utilisateur donné en paramètre
     * @param int $user_id Identifiant unique de l'utilisateur
     * @param string $password Le mot de passe à vérifier
     * @return bool Vrai s'il est correct, faux sinon.
     */
    public function check_password(int $user_id, string $password): bool {
        $database_link = new DatabaseLink();
        $query = $database_link->make_query("SELECT `password` FROM `users` WHERE `id_user` = ?", [$user_id]);

        $password_in_database = $query->fetchColumn();

        if (password_verify($password, $password_in_database)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Méthode permettant de modifier le mot de passe d'un utilisateur
     * @param int $user_id Identifiant unique de l'utilisateur
     * @param string $new_password Le nouveau mot de passe
     */
    public function change_password(int $user_id, string $new_password) {
        $database_link = new DatabaseLink();
        $secure_password = password_hash($new_password, PASSWORD_ARGON2ID);
        $database_link->make_query("UPDATE `users` SET `password` = ? WHERE `id_user` = ?", [$secure_password, $user_id]);
    }
    
    /**
     * Méthode pour déconnecter un utilisateur
     */
    public function logout() {
        unset($_SESSION["user"]);
        unset($_SESSION["user_token"]);
    }
}